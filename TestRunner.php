#!/usr/bin/php 
<?php

include_once('IProfile.php');
class TestRunner {
    const ITERATIONS = 1000;
    const REPETITIONS = 100;

    protected $profiles = array();
    protected $median = array();
    protected $mean = 0;
    protected $startTime = null;
    protected $endTime = null;

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
        $this->startTime = microtime(true);

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

                $label = $this->getLabel($method);

                $startLine = $method->getStartLine();
                $endLine   = $method->getEndLine();

                $repetitions  = static::REPETITIONS;
                $iterations   = static::ITERATIONS;
                $totalDuration = 0;
                $min = null;
                $max = null;

                $fn = $method->name;

                $alias = $this->getAlias($method);
                if ($alias) {
                    $this->writeLine("Method is alias for ".$alias);
                    // helloooo alias! store a pointer for later
                    $result = array(
                        'alias'     => $alias,
                        'method'    => $fn,
                        'startLine' => $startLine,
                    );
                } else {
                    // unless explicitly defined we just take the first line of the profile as our label
                    if (!$label) {
                        $label = trim($classLines[$startLine]);
                    }
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
                        'method'      => $fn,
                        'label'       => $label,
                        'mean'        => $mean,
                        'single'      => bcdiv($rawMean, $iterations, 6),
                        /*
                        'min'         => $min,
                        'max'         => $max,
                        */
                        'startLine'   => $startLine,
                    );
                    $this->mean += $mean;
                    $this->median[] = $mean;
                }
                $results[] = $result;
            }

            $this->profiles[] = array(
                'class'    => $class,
                'title'    => $instance->getTitle(),
                'filename' => basename($reflection->getFilename()),
                'results'  => $results,
            );
        }

        /**
         * resolve aliases
         */
        $this->writeLine("Resolving aliases...");
        $this->resolveProfileAliases();


        /**
         * resolve group percentage differences
         */
        foreach ($this->profiles as $i => $profile) {

            $groupMedian = $this->getMedian(array_map(function($v) {
                return $v['mean'];
            }, $profile['results']));

            foreach($profile['results'] as $j => $result) {
                $result['pc_group'] = (($result['mean'] / $groupMedian) * 100) - 100;
                $this->profiles[$i]['results'][$j] = $result;
            }
        }

        $this->median = $this->getMedian($this->median);

        $this->mean = bcdiv($this->mean, count($this->profiles), 6);

        foreach ($this->profiles as $i => $profiles) {
            foreach($profiles['results'] as $j => $stats) {
                $stats['pc_suite'] = (($stats['mean'] / $this->median) * 100) - 100;
                $this->profiles[$i]['results'][$j] = $stats;
            }
        }
        $this->endTime = microtime(true);

        $this->write(json_encode(array(
            'meta' => array(
                'duration'    => ($this->endTime - $this->startTime),
                'iterations'  => self::ITERATIONS,
                'repetitions' => self::REPETITIONS,
                'mean'        => $this->mean,
                'median'      => $this->median,
            ),
            'profiles' => $this->profiles,
        )));
    }

    protected function resolveProfileAliases() {
        foreach ($this->profiles as $i => $profile) {
            foreach($profile['results'] as $j => $result) {
                if (isset($result['alias'])) {
                    $this->profiles[$i]['results'][$j] = $this->resolveAlias($result);
                }
            }
        }
    }
    
    protected function resolveAlias($alias) {
        list($class, $method) = explode("::", $alias['alias']);

        foreach ($this->profiles as $i => $profile) {

            if ($profile['class'] == $class) {

                foreach ($profile['results'] as $result) {
                    if ($result['method'] == $method) {

                        // keep averages in check
                        $this->mean += $result['mean'];
                        $this->median[] = $result['mean'];
                        
                        // override return values with alias's original label if it has one
                        return array_merge(
                            $result, 
                            $alias
                        );
                    }
                }
            }
        }
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

    protected function getAlias($method) {
        $docComment = $method->getDocComment();
        if ($docComment) {
            if (preg_match("/@alias\s(.+)/", $docComment, $matches)) {
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
