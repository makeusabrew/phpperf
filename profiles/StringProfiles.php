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

    public function profileStrlen() {
        strlen("some random arbitrary string here");
    }
}
