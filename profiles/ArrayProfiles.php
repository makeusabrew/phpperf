<?php

class ArrayProfiles implements IProfile {
    public function getTitle() {
        return "Array methods";
    }

    public function profileArrayMerge() {
        array_merge(array("foo" => "bar"), array("baz" => "test"));
    }
}
