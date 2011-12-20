<?php

class PregMatchProfiles {
    public function profilePregMatch() {
        //
        preg_match("/^(.+)$/", "test");
    }

    public function profilePregMatchStoreMatches() {
        //
        preg_match("/^(.+)$/", "test", $matches);
    }
}
