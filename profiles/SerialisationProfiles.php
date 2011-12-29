<?php

class SerialisationProfiles implements IProfile {
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
        return "Serialisation methods";
    }

    public function profileJsonEncodeOnSimpleString() {
        json_encode("simple string");
    }

    /**
     * @alias VariableProfiles::profileSerializeOnSimpleString
     */
    public function profileSerializeStringAlias() { }
}
