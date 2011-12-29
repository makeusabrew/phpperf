<?php

class VariableProfiles implements IProfile {
    public function __construct() {
        $this->string = "foo";
        $this->bool   = true;
        $this->integer= 1234;

        $object = new stdClass();
        $object->foo = "bar";
        $object->baz = "test";
        $object->int = 1234;
        $this->object = $object;
    }

    public function getTitle() {
        return "Variable methods";
    }

    public function profileIsEmptyOnSimpleString() {
        empty($this->string);
    }

    /*
    public function profileIsEmptyOnBoolean() {
        empty($this->bool);
    }

    public function profileIsEmptyOnInteger() {
        empty($this->integer);
    }
    */

    public function profileIsIntOnString() {
        is_int("string");
    }

    /*
    public function profileIsIntOnBool() {
        is_int($this->bool);
    }

    public function profileIsIntOnInteger() {
        is_int($this->integer);
    }
    */

    public function profileIsCallable() {
        is_callable("unknownFunction");
    }

    public function profileSerializeOnSimpleString() {
        serialize("simple string");
    }

    public function profileSerializeOnInteger() {
        serialize(12345);
    }

    public function profileSerializeOnBool() {
        serialize(true);
    }

    public function profileSerializeOnSimpleObject() {
        serialize($this->object);
    }
}
