#!/usr/bin/php 
<?php

include_once('IProfile.php');
class TestRunner {
    const ITERATIONS = 1000;
    const REPETITIONS = 100;

    protected $profiles = array();

    public function setClasses($classes) {
        $this->classes = $classes;
    }

    protected function writeLine($str) {
        fwrite(STDERR, $str."\n");
    }

    protected function write($str) {
        fwrite(STDOUT, $str);
    }

    public function run() {
        $suiteMean = 0;
        $suiteProfiles = 0;
        $suiteMedian = array();

        foreach ($this->classes as $class) {
            $this->writeLine("Profiling ".$class);

            $reflection = new ReflectionClass($class);
            // read in the entire file into an array, useful for line related antics later
            $classLines = file($reflection->getFileName());

            $instance = new $class();

            $results = array();

            foreach ($reflection->getMethods() as $method) {
                if (strpos($method->name, "profile") !== 0) {
                    continue;
                }
                $this->writeLine("Method: ".$method->name);

                $startLine = $method->getStartLine();
                $endLine   = $method->getEndLine();

                $label = $this->getLabel($method);

                // unless explicitly defined we just take the first line of the profile as our label
                if (!$label) {
                    $label = trim($classLines[$startLine]);
                }
                $repetitions  = static::REPETITIONS;
                $iterations   = static::ITERATIONS;
                $totalDuration = 0;
                $min = null;
                $max = null;

                $fn = $method->name;

                // output buffering is important for methods which would ordinarily write to it
                ob_start();
                for ($i = 0; $i < $repetitions; $i++) {
                    $start = microtime(true);
                    for ($j = 0; $j < $iterations; $j++) {
                        $instance->$fn();
                    }
                    $end = microtime(true);
                    $duration = $end - $start;
                    if ($min === null || $duration < $min) {
                        $min = $duration;
                    }
                    if ($max === null || $duration > $max) {
                        $max = $duration;
                    }
                    $totalDuration += $duration;
                }

                // discard whatever the test method dumped in the output buffer
                ob_end_clean();

                $mean = bcdiv($totalDuration, $repetitions, 6);
                $rawMean = ($totalDuration / $repetitions);
                $result = array(
                    'label'       => $label,
                    'mean'        => $mean,
                    'single'      => bcdiv($rawMean, $iterations, 6),
                    'min'         => $min,
                    'max'         => $max,
                    'startLine'   => $startLine,
                );
                $results[] = $result;
                $suiteMean += $mean;
                $suiteProfiles ++;
                $suiteMedian[] = $mean;
            }

            /*
            $groupMedian = array();
            foreach ($results as $result) {
                $groupMedian[] = $result['mean'];
            }
            */
            
            $groupMedian = $this->getMedian(array_map(function($v) {
                return $v['mean'];
            }, $results));

            foreach($results as $i => $result) {
                $result['pc_group'] = (($result['mean'] / $groupMedian) * 100) - 100;
                $results[$i] = $result;
            }

            $this->profiles[] = array(
                'title'    => $instance->getTitle(),
                'filename' => basename($reflection->getFilename()),
                'results'  => $results,
            );
        }

        $suiteMedian = $this->getMedian($suiteMedian);

        $suiteMean = bcdiv($suiteMean, $suiteProfiles, 6);

        foreach ($this->profiles as $i => $profiles) {
            foreach($profiles['results'] as $j => $stats) {
                $stats['pc_suite'] = (($stats['mean'] / $suiteMedian) * 100) - 100;
                $this->profiles[$i]['results'][$j] = $stats;
            }
        }

        $this->write(json_encode(array(
            'meta' => array(
                'iterations'  => self::ITERATIONS,
                'repetitions' => self::REPETITIONS,
                'mean'        => $suiteMean,
                'median'      => $suiteMedian,
            ),
            'profiles' => $this->profiles,
        )));
    }

    protected function getLabel($method) {
        $docComment = $method->getDocComment();
        if ($docComment) {
            if (preg_match("/@label\s(.+)/", $docComment, $matches)) {
                return $matches[1];
            }
        }
        return false;
    }

    protected function getMedian($values) {
        sort($values);
        if (count($values) % 2 == 0) {
            // even, take an average of the middle two
            $top = count($values) / 2;
            $bottom = $top - 1;

            $median = bcdiv($values[$bottom] + $values[$top], 2, 6);
        } else {
            $idx = floor(count($values) / 2);
            $median = $values[$idx];
        }
        return $median;
    }
}

$classes = array();

foreach (glob("profiles/*.php") as $filename) {
    include_once($filename);
}

foreach (get_declared_classes() as $strClass) {
    $class = new ReflectionClass($strClass);
    if ($class->implementsInterface('IProfile')) {
        $classes[] = $strClass;
    }
}

$tr = new TestRunner();
$tr->setClasses($classes);
$tr->run();
