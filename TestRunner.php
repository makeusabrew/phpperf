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
        $globalMean = 0;
        $globalProfiles = 0;
        foreach ($this->classes as $k => $class) {
            $reflection = new ReflectionClass($class);
            $classLines = file($reflection->getFileName());
            $filename = basename($reflection->getFilename());

            $instance = new $class();
            $title = $instance->getTitle();

            $this->writeLine("Profiling ".$class);
            $this->profiles[$k] = array(
                'title' => $title,
                'filename' => $filename,
                'results' => array(),
            );

            $methods = $reflection->getMethods();

            $results = array();

            foreach ($methods as $method) {
                if (strpos($method->name, "profile") !== 0) {
                    continue;
                }
                $this->writeLine("Method: ".$method->name);

                $startLine = $method->getStartLine();
                $endLine   = $method->getEndLine();

                $label = $this->getLabel($method);
                if (!$label) {
                    $label = trim($classLines[$startLine]);
                }
                $repetitions = static::REPETITIONS;
                $iterations = static::ITERATIONS;
                $totalDuration = 0;
                $min = null;
                $max = null;
                $fn = $method->name;
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
                ob_end_clean();
                $mean = bcdiv($totalDuration, $repetitions, 6);
                $result = array(
                    'label'       => $label,
                    'mean'        => $mean,
                    'single'      => bcdiv(($totalDuration / $repetitions), $iterations, 6),
                    'min'         => $min,
                    'max'         => $max,
                    'startLine'   => $startLine,
                );
                $results[] = $result;
                $globalMean += $mean;
                $globalProfiles ++;
            }

            $this->profiles[$k]['results'] = $results;
        }

        $globalMean = bcdiv($globalMean, $globalProfiles, 6);
        foreach ($this->profiles as $i => $profiles) {
            foreach($profiles['results'] as $j => $stats) {
                $stats['pc'] = (($stats['mean'] / $globalMean) * 100) - 100;
                $this->profiles[$i]['results'][$j] = $stats;
            }
        }

        $this->write(json_encode(array(
            'meta' => array(
                'iterations' => self::ITERATIONS,
                'repetitions' => self::REPETITIONS,
                'mean' => $globalMean,
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
