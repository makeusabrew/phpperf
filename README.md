#phpperf

## Contributing

### Adding a profile to an existing group

1. Add your method to the relevant class in the ```profiles``` folder
2. The method name *must* begin with ```profile``` - other than that, it's up to you as long as it's unique within the class
3. Add the low-level PHP method you're profiling within this method, e.g:

    public function profileStrlenWithShortString() {
        strlen("This is a string");
    }

4. By default the label used will be the *actual* code you're profiling, but if this gets too verbose or your profile is multiline, try:

    /**
     * @label strlen() with a huge string
     */
    public function profileStrlenWithHugeString() {
        $str = "some very very very very very very ".
               "very very very very very very very ".
               "very very very very very very very ".
               "long string here";
        strlen($str);
    }

### Adding a new group

1. Add your new file within the ```profiles``` folder
2. Add a unique class - the only rule is that it *must* implement the ```IProfile``` interface
3. This interface only requires that you implement one method: ```getTitle()``` which provides the profile group name
4. Follow the instructions above until you're all done!