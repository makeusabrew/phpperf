<?php

class DateProfiles implements IProfile {

    public function getTitle() {
        return "date() methods";
    }

    public function profileDateWithTypicalString() {
        date("Y-m-d H:i:s");
    }

    public function profileDateWithSingleYear() {
        date("Y");
    }
}
