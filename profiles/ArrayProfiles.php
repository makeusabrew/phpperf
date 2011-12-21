<?php

class ArrayProfiles implements IProfile {
    public function __construct() {
        $this->mediumArray1 = range(0, 100);
        $this->mediumArray2 = range(0, 100);
    }

    public function getTitle() {
        return "Array methods";
    }

    public function profileArrayFillSmall() {
        array_fill(0, 10, 'foo');
    }

    public function profileArrayFillMediumNegativeOffset() {
        array_fill(-50, 100, 'foobar');
    }

    public function profileArrayFillMedium() {
        array_fill(0, 100, 'bar');
    }

    public function profileArrayFillLarge() {
        array_fill(0, 1000, 'baz');
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

    public function profileShuffleMediumArray() {
        shuffle($this->mediumArray1);
    }
}
