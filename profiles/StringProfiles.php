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

    /**
     * @label htmlentities() with ENT_QUOTES flag
     */
    public function profileHtmlEntitiesQuotes() {
        htmlentities("this 'is' a <strong>test</strong> <div>\"string!?\"</div>", ENT_QUOTES);
    }

    public function profileHtmlSpecialChars() {
        htmlspecialchars("this 'is' a <strong>test</strong> <div>\"string!?\"</div>");
    }

    /**
     * @label htmlspecialchars() with ENT_QUOTES flag
     */
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

    public function profileAddSlashesWithSimpleString() {
        addslashes("This string contains nothing which will be replaced");
    }

    public function profileAddSlashesWithStringRequiringReplacement() {
        addslashes("'this string' will 'need ' \" \lots of ''' replacement''");
    }

    /*
    public function profileCryptWithString() {
        crypt("the string to encrypt");
    }
    */

    public function profileCryptWithSalt() {
        crypt("the string to encrypt", "salt");
    }

    public function profileLcFirst() {
        lcfirst("This is a test string - uppercase");
    }

    public function profileLcFirstAlreadyLowercase() {
        lcfirst("this is a test string - lowercase");
    }

    public function profileUcFirstUppercase() {
        ucfirst("This is a test string - uppercase");
    }

    public function profileUcFirstAlreadyLowercase() {
        ucfirst("this is a test string - lowercase");
    }

    public function profileUcWordsUppercase() {
        ucwords("This Is A Test String - Uppercase");
    }

    public function profileUcFirstLowercase() {
        ucwords("this is a test string - lowercase");
    }

    public function profileLevenshteinWithMatchingStrings() {
        levenshtein("this string matches", "this string matches");
    }

    public function profileLevenshteinWithSimilarStrings() {
        levenshtein("this is a string", "this si string");
    }

    public function profileLevenshteinWithOppositeStrings() {
        levenshtein("this is a string", "gnirts a si siht");
    }

    public function profileTrimWithNoSpacedPadding() {
        trim("this has no padding");
    }

    public function profileTrimWithSpacedPaddingLeft() {
        trim("    this string has padding on the left");
    }

    public function profileTrimWithSpacedPaddingRight() {
        trim("this string has padding on the right     ");
    }

    public function profileTrimWithSpacedPadding() {
        trim("     this string has padding on both sides     ");
    }

    public function profileStringConcatenationWithDot() {
        "some string"."some other string";
    }

    /**
     * @label "some string$some_other_string"
     */
    public function profileStringConcatenationWithInterpolation() {
        $some_other_string = "some other string";
        "some string$some_other_string";
    }

    /**
     * @label string dot concatenation with ~520 char string 
     */
    public function profileStringConcatenationWithDotLargeString() {
        "some string".$this->largeStr;
    }

    /**
     * @label string concatenation with interpolation with ~520 char string 
     */
    public function profileStringConcatenationWithInterpolationLargeString() {
        "some string{$this->largeStr}";
    }
}
