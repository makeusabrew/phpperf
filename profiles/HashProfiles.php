<?php

class HashProfiles implements IProfile {
    public function getTitle() {
        return "Hashing methods";
    }

    /**
     * @alias StringProfiles::profileMd5
     */
    public function profileMd5() {
        // this method is just an alias. This mechanism could be improved!
    }

    /**
     * @alias StringProfiles::profileSha1
     */
    public function profileSha1() {
        // this method is just an alias. This mechanism could be improved!
    }

}
