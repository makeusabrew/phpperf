<?php

class DateProfiles implements IProfile {

    public function getTitle() {
        return "Date methods";
    }

    public function profileDateWithTypicalString() {
        date("Y-m-d H:i:s");
    }

    public function profileDateWithSingleYear() {
        date("Y");
    }

    public function profileDateWithAnotherTypicalString() {
        date("l jS F Y");
    }
}
