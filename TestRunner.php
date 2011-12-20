<?php

include("DateProfiles.php");
include("PregMatchProfiles.php");
class TestRunner {
    const ITERATIONS = 10000;
    const REPETITIONS = 50;

    protected $results = array();

    public function setClasses($classes) {
        $this->classes = $classes;
    }

    public function run() {
        foreach ($this->classes as $class) {
            echo "Profiling ".$class."\n";
            $this->results[$class] = array();

            $instance = new $class();
            $methods = get_class_methods($instance);

            foreach ($methods as $method) {
                echo "Method: ".$method."\n";
                $repetitions = static::REPETITIONS;
                $iterations = static::ITERATIONS;
                $duration = 0;
                for ($i = 0; $i < $repetitions; $i++) {
                    $start = microtime(true);
                    for ($j = 0; $j < $iterations; $j++) {
                        $instance->$method();
                    }
                    $end = microtime(true);
                    $duration += $end - $start;
                }
                $this->results[$class][$method] = $duration / $repetitions;
            }
        }

        var_dump($this->results);
    }
}

$classes = array(
    'DateProfiles',
    'PregMatchProfiles',
);

$tr = new TestRunner();
$tr->setClasses($classes);
$tr->run();
