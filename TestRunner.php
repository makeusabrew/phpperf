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
        foreach ($this->classes as $class) {
            $instance = new $class();
            $meta = $instance->getMethods();
            $title = $instance->getTitle();

            $this->writeLine("Profiling ".$class);
            $this->results[$title] = array();

            $methods = get_class_methods($instance);

            $k = 0;
            foreach ($methods as $method) {
                if (strpos($method, "profile") !== 0) {
                    continue;
                }
                $this->writeLine("Method: ".$method);
                $label = isset($meta[$method]['label']) ? $meta[$method]['label'] : $method;
                $repetitions = static::REPETITIONS;
                $iterations = static::ITERATIONS;
                $totalDuration = 0;
                $min = null;
                $max = null;
                for ($i = 0; $i < $repetitions; $i++) {
                    $start = microtime(true);
                    for ($j = 0; $j < $iterations; $j++) {
                        $instance->$method();
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
                $result = array(
                    'label'       => $label,
                    'iterations'  => $iterations,
                    'repetitions' => $repetitions,
                    'mean'        => bcdiv($totalDuration, $repetitions, 6),
                    'single'      => bcdiv(($totalDuration / $repetitions), $iterations, 6),
                    'min'         => $min,
                    'max'         => $max,
                );
                $this->results[$title][$k] = $result;
                $k++;
            }
        }

        $this->write(json_encode($this->results));
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
