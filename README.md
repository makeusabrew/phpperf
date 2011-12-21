#phpperf

PHP Performance Metrics for low-level PHP methods.

## Contributing

### Adding a profile to an existing group

1. Add your method to the relevant class in the ```profiles``` folder
2. The method name *must* begin with ```profile``` - other than that, it's up to you as long as it's unique within the class
3. Add the low-level PHP method you're profiling within this method.

E.g:

```php
<?php
/* ...snip... */

public function profileStrlenWithShortString() {
    strlen("This is a string");
}
```

By default the label used will be the *actual* code you're profiling, but if this gets too verbose or your profile is multiline, try:

```php
<?php
/* ...snip... */

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
```

### Adding a new group

1. Add your new file within the ```profiles``` folder
2. Add a unique class - the only rule is that it *must* implement the ```IProfile``` interface
3. This interface only requires that you implement one method: ```getTitle()``` - this provides the profile group name
4. Follow the instructions above until you're all done!

## Running your own benchmark

If you've added new profiles or an entire group of profiles, you'll want to run a benchmark to make sure everything
looks in order before submitting a pull request. The benchmarking tools are actually split into separate parts -
a Test Runner and an HTML Reporter, but by chaining these together you'll get the desired results:

```you@desktop:~/code/web/phpperf$ ./TestRunner.php | ./HtmlReporter.php > results.html ```

Simply open ```results.html``` in a web browser and check your profiles are rendered as expected.

## Pull Requests

Please do *not* submit a pull request to the gh-pages branch with your own results.html page. The goal of the project
is not to collect distributed performance benchmarks, but to provide a baseline for which some sense of relative
and absolute performance can be guaged. Of course, you're welcome to publish and share your own results, but contributions
to this project are far better served by either:

1. Improving the benchmark logic (better accuracy, more comparisons, more functionality)
2. Adding more profiles

## License

Apache 2.0