<?php

class StringProfiles implements IProfile {
    public function getTitle() {
        return "String functions";
    }

    public function profileEchoSmallString() {
        echo "foo bar baz test";
    }

    /**
     * @label echo with large string (~520 chars)
     */
    public function profileEchoLargeString() {
        $str = "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ";
        echo $str;
    }

    public function profileExplodeSmallString() {
        explode(" ", "foo bar baz test baz bar foo");
    }

    /**
     * @label explode() on space with large input string
     */
    public function profileExplodeLargeString() {
        $str = "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
               "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ";
        explode(" ", $str);
    }

    public function profileImplodeSmallArray() {
        implode(" ", array("foo", "bar", "baz", "test", "baz", "bar", "foo"));
    }

    public function profileStrReplace() {
        str_replace("foo", "bar", "foobarfoobar");
    }
}
