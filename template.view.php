<!doctype html>
<html>
    <head>
        <title>PHP Performance Metrics</title>
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
        <meta name="google-site-verification" content="25AfGx-XF6ikgholPhv2GQ5sTxLz0gk13Eklidw3bds" />
        <style>
            table tr td,
            table tr th {
                /*font-size:85%;*/
            }

            tr.group th {
                font-weight:bold;
                background:#eee !important;
                color:#000 !important;
            }
            code {
                background-color:inherit;
                color:inherit;
                padding:0;
                font-family:"Inconsolata", "Monaco", "Consolas", "Courier New", Courier, monospace;
                font-size:85%;
            }

            .well iframe {
                width:190px !important;
            }
        </style>
        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-20517424-7']);
          _gaq.push(['_setDomainName', 'phpperf.com']);
          _gaq.push(['_setAllowLinker', true]);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </head>
    <body>
        <a href="<?php echo $this->url ?>"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub" /></a>
        <div class=container>
            <div class='page-header'>
                <div style='margin-top:11px;float:right'>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-via="makeusabrew">Tweet</a>
                </div>
                <h1>PHP Performance Metrics</h1>
            </div>

            <p>The table below shows methods loosely grouped by type and usage. The column representing a <em>single</em>
            method call is derived solely from dividing the mean value by the number of iterations, so it is approximate.</p>

            <p>Each test comprises of <strong><?php echo number_format($this->meta['iterations']) ?></strong> method calls
            averaged over <strong><?php echo $this->meta['repetitions'] ?></strong> repetitions.</p>
            <p>The median profile takes <strong><?php echo $this->meta['median'] ?> seconds</strong> to run <?php echo number_format($this->meta['iterations']) ?>
            times. This value is used to calculate the relative percentage costs across both the group and suite of profiled functions.</p>

            <p>You can click on any group's heading to view the profile class as a whole, or you can click on each
            individual method to be taken to the source code behind each profile &ndash; particularly useful
            if the profile label is a summary rather than actual code.</p>


            <div class='page-header'>
                <h2>Units of measurement</h2>
            </div>

            <ul>
                <li><strong>&mu;s</strong> &ndash; <a href="http://en.wikipedia.org/wiki/Microsecond">microseconds</a>, equivalent to 0.001 milliseconds. It takes roughly 350,000 of these to blink your eye</li>
                <li><strong>s</strong> &ndash; the humble <a href="http://en.wikipedia.org/wiki/Second">second</a>.</li>
            </ul>

            <div class='page-header'>
                <h2>Benchmark</h2>
            </div>

            <p>All of these tests are compiled using the same machine each time. Inevitably, each
            run may vary, but the differences should be slight and the relative performance should be fairly consistent.</p>
            <ul>
                <li>AMD Athlon(tm) 64 X2 Dual Core Processor 4200+ (2.2 GHz)</li>
                <li>3Gb RAM</li>
                <li>Ubuntu 11.10 Desktop Edition</li>
                <li>PHP <?php echo phpversion() ?></li>
            </ul>

            <h2>Results</h2>

            <table class="zebra-striped bordered-table">
                <thead>
                    <?php /*
                    <tr>
                        <th>&nbsp;</th>
                        <th>&times; <?php echo number_format($this->meta['iterations']) ?></th>
                        <th>1</th>
                        <th>Relative</th>
                    </tr>
                    */ ?>
                </thead>
                <tbody>
                    <?php foreach($this->profiles as $profile): ?>
                        <tr class=group>
                            <th><a href='<?php echo $this->url.'tree/master/profiles/'.$profile['filename'] ?>'><?php echo $profile['title'] ?></a></th>
                            <th>&times; <?php echo number_format($this->meta['iterations']) ?></th>
                            <th>&times; 1</th>
                            <th>Group</th>
                            <th>Suite</th>
                        </tr>
                        <?php foreach($profile['results'] as $stats): ?>
                            <tr>
                                <td><a href='<?php echo $this->url.'tree/master/profiles/'.$profile['filename'] ?>#L<?php echo $stats['startLine'] ?>'><?php echo $this->highlight($stats['label']) ?></a></td>
                                <td><?php echo $stats['mean'] ?>s</td>
                                <td><?php echo $this->microformat($stats['single']) ?></td>
                                <td class='<?php echo ($stats['pc_group'] < 0) ? 'good' : 'bad' ?>'><?php if ($stats['pc_group'] > 0):?>+<?php endif; ?><?php echo round($stats['pc_group'], 2) ?>&#37;</td>
                                <td class='<?php echo ($stats['pc_suite'] < 0) ? 'good' : 'bad' ?>'><?php if ($stats['pc_suite'] > 0):?>+<?php endif; ?><?php echo round($stats['pc_suite'], 2) ?>&#37;</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class='page-header'>
                <h2>About phpperf.com</h2>
            </div>

            <p>The main goal of this project is to illustrate the relative costs of commonly used low-level PHP methods, and to try and give some sort
            of baseline as to how long these methods can take in isolation. All too often you'll hear methods being dismissed as &ldquo;expensive&rdquo;
            without any form of empirical evidence either way, and similarly you'll hear PHP bemoaned as being &ldquo;slow&rdquo; &ndash; but
            of course both these terms are relative. Sure, PHP might be slow compared to other languages, but this can quickly be blown
            out of proportion and lead people to assume it's actually <em>slow</em>, and that a smattering of functions will bring your application to
            its knees. These tests simply exist to give some grounding and points-of-reference to these sorts of conversations.</p>

            <div class='page-header'>
                <h2>Disclaimer</h2>
            </div>

            <p>These tests don't run in a vacuum &ndash; inevitably no two runs will yield the same results, and even then only serve
            as a rough baseline based on the machine I run them on &ndash; your results may differe significantly. The mechanism used to
            run and time the tests probably isn't the most scientific either, so if you've got a suggestion then
            please do <a href="<?php echo $this->url ?>">fork the project</a> &ndash; any improvements are welcome!</p>

            <div class='page-header'>
                <h2>Contributing</h2>
            </div>

            <p><b>phpperf</b> needs you! There are <em>loads</em> of methods and common use-cases not yet profiled.
            Please see the <a href='<?php echo $this->url ?>#readme'>readme</a> file for how to add your own profiles (it's quick &amp; easy!).
            Every contributor will be listed here in the order they first helped out with the project. Think of the fame!</p>
            <ul>
                <li><a href="http://twitter.com/makeusabrew">@makeusabrew</a> (author)</li>
            </ul>

        </div>
        <footer class='well container'>
            <div style='float:right'>
                <a href="https://twitter.com/share" class="twitter-share-button" data-via="makeusabrew" data-size="large">Tweet</a>
                <a href="https://twitter.com/makeusabrew" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @makeusabrew</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
            Made by <a href="http://twitter.com/makeusabrew">@makeusabrew</a>.
            Licensed under the <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache License v2.0</a>.
        </footer>
    </body>
</html>
