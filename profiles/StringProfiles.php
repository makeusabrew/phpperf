<?php

class StringProfiles implements IProfile {
    
    public function __construct() {
        $this->largeStr =
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ".
           "foo bar baz test foo foo foo test foo bar baztestfootest foo bar ";
    }

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
        explode(" ", $this->largeStr);
    }

    public function profileHtmlEntities() {
        htmlentities("this 'is' a <strong>test</strong> <div>\"string!?\"</div>");
    }

    public function profileHtmlEntitiesQuotes() {
        htmlentities("this 'is' a <strong>test</strong> <div>\"string!?\"</div>", ENT_QUOTES);
    }

    public function profileHtmlSpecialChars() {
        htmlspecialchars("this 'is' a <strong>test</strong> <div>\"string!?\"</div>");
    }

    public function profileHtmlSpecialCharsQuotes() {
        htmlspecialchars("this 'is' a <strong>test</strong> <div>\"string!?\"</div>", ENT_QUOTES);
    }

    public function profileImplodeSmallArray() {
        implode(" ", array("foo", "bar", "baz", "test", "baz", "bar", "foo"));
    }

    public function profileMd5() {
        md5("abcdefghijklmnopqrstuvwxyz");
    }

    /**
     * @label md5() with ~520 char string
     */
    public function profileMd5LargeStr() {
        md5($this->largeStr);
    }

    public function profileSha1() {
        sha1("abcdefghijklmnopqrstuvwxyz");
    }

    /**
     * @label sha1() with ~520 char string
     */
    public function profileSha1LargeStr() {
        sha1($this->largeStr);
    }

    public function profileStrlen() {
        strlen("some random arbitrary string here");
    }

    public function profileStrPadLeft() {
        str_pad("TestStr", 20, STR_PAD_LEFT);
    }

    public function profileStrPadRight() {
        str_pad("TestStr", 20);
    }

    public function profileStrPosStartOfHaystack() {
        strpos("abcdefghijklmnopqrstuvwxyq", "a");
    }

    public function profileStrPosMiddleOfHaystack() {
        strpos("abcdefghijklmnopqrstuvwxyq", "m");
    }

    public function profileStrPosEndOfHaystack() {
        strpos("abcdefghijklmnopqrstuvwxyq", "z");
    }

    public function profileStrReplace() {
        str_replace("foo", "bar", "foobarfoobar");
    }

    public function profileStrShuffleMediumString() {
        str_shuffle("abcdefghijklmnopqrstuvwxyz");
    }

    /**
     * @label str_shuffle() with a large (~520 char) string
     */
    public function profileStrShuffleLargeString() {
        str_shuffle($this->largeStr);
    }
}
