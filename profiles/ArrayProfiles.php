<?php

class ArrayProfiles implements IProfile {
    public function __construct() {
        $this->mediumArray1 = range(0, 100);
        $this->mediumArray2 = range(0, 100);
    }

    public function getTitle() {
        return "Array methods";
    }

    public function profileArrayMerge() {
        array_merge(array("foo" => "bar"), array("baz" => "test"));
    }

    /**
     * @data L5
     */
    public function profileArrayMergeMediumArrays() {
        array_merge($this->mediumArray1, $this->mediumArray2);
    }
}
