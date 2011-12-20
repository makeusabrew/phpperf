<?php

class DateProfiles implements IProfile {

    public function getTitle() {
        return "date() methods";
    }

    public function getMethods() {
        return array(
            'profileDateWithTypicalString' => array(
                'label' => 'date("Y-m-d H:i:s")'
            ),
            'profileDateWithSingleYear' => array(
                'label' => 'date("Y")',
            ),
        );
    }

    public function profileDateWithTypicalString() {
        date("Y-m-d H:i:s");
    }

    public function profileDateWithSingleYear() {
        date("Y");
    }
}
