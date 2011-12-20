#!/usr/bin/php 
<?php

include_once('IProfile.php');
class TestRunner {
    const ITERATIONS = 1000;
    const REPETITIONS = 100;

    protected $results = array();

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
        $classMean = 0;
        $classProfiles = 0;
        foreach ($this->classes as $class) {
            $reflection = new ReflectionClass($class);
            $classLines = file($reflection->getFileName());

            $instance = new $class();
            $title = $instance->getTitle();

            $this->writeLine("Profiling ".$class);
            $this->results[$title] = array();

            $methods = $reflection->getMethods();

            $k = 0;

            foreach ($methods as $method) {
                if (strpos($method->name, "profile") !== 0) {
                    continue;
                }
                $this->writeLine("Method: ".$method->name);
                $label = $this->getLabel($method);
                if (!$label) {
                    $startLine = $method->getStartLine();
                    $endLine   = $method->getEndLine();
                    $label = trim($classLines[$startLine]);
                }
                $repetitions = static::REPETITIONS;
                $iterations = static::ITERATIONS;
                $totalDuration = 0;
                $min = null;
                $max = null;
                $fn = $method->name;
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
                $mean = bcdiv($totalDuration, $repetitions, 6);
                $result = array(
                    'label'       => $label,
                    'mean'        => $mean,
                    'single'      => bcdiv(($totalDuration / $repetitions), $iterations, 6),
                    'min'         => $min,
                    'max'         => $max,
                );
                $this->results[$title][$k] = $result;
                $k++;
                $classMean += $mean;
                $classProfiles ++;
            }
        }

        $classMean = bcdiv($classMean, $classProfiles, 6);
        foreach ($this->results as $title => $results) {
            $k = 0;
            foreach($results as $stats) {
                $stats['pc'] = (($stats['mean'] / $classMean) * 100) - 100;
                $this->results[$title][$k] = $stats;
                $k++;
            }
        }

        $this->write(json_encode(array(
            'meta' => array(
                'iterations' => self::ITERATIONS,
                'repetitions' => self::REPETITIONS,
                'mean' => $classMean,
            ),
            'results' => $this->results,
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
