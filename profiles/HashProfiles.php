<?php

class HashProfiles implements IProfile {
    public function getTitle() {
        return "Hashing methods";
    }

    /**
     * @alias StringProfiles::profileMd5
     */
    public function profileMd5Alias() {
        // this method is just an alias. This mechanism could be improved!
    }

    /**
     * @alias StringProfiles::profileMd5LargeStr
     */
    public function profileMd5LargeStrAlias() {
        // this method is just an alias. This mechanism could be improved!
    }

    /**
     * @alias StringProfiles::profileSha1
     */
    public function profileSha1Alias() {
        // this method is just an alias. This mechanism could be improved!
    }

    /**
     * @alias StringProfiles::profileSha1LargeStr
     */
    public function profileSha1LargeStrAlias() {
        // this method is just an alias. This mechanism could be improved!
    }

}
