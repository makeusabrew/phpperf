<!doctype html>
<html>
    <head>
        <title>PHP Performance Charts</title>
        <link rel="stylesheet" href="http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css">
        <style>
            td.group {
                font-weight:bold;
                background:#eee !important;
                color:#000 !important;
            }
            code {
                background-color:inherit;
                color:inherit;
                padding:0;
                font-size:70%;
            }
        </style>
    </head>
    <body>
        <a href="<?php echo $this->url ?>../../../"><img style="position: absolute; top: 0; right: 0; border: 0;" src="http://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub" /></a>
        <div class=container>
            <div class='page-header'>
                <h1>PHP Performance Metrics</h1>
            </div>

            <p>Each test comprises of <strong><?php echo number_format($this->meta['iterations']) ?></strong> method calls
            averaged over <strong><?php echo $this->meta['repetitions'] ?></strong> repetitions.</p>
            <p>The mean profile takes <strong><?php echo $this->meta['mean'] ?> seconds</strong> to run the average method <?php echo number_format($this->meta['iterations']) ?> times.</p>


            <div class='page-header'>
                <h2>Results</h2>
            </div>

            <p>The results table below shows methods loosely grouped by type and usage. The column representing a <em>single</em>
            method call is derived solely from dividing the mean value by the number of iterations, so it is approximate.
            The relative column shows the cost of the method Vs the average across all profiled functions.</p>

            <p>You can click on any group's heading to view the profile class as a whole, or you can click on each
            individual method to be taken to the source code behind each profile &ndash; particularly useful
            if the profile label is a summary rather than actual code.</p>

            <div class='page-header'>
                <h2>Units</h2>
            </div>

            <p><strong>&mu;s</strong> &ndash; microsecond. It takes roughly 350,000 of these to blink your eye.</p>

            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>&times; <?php echo number_format($this->meta['iterations']) ?></th>
                        <th>1</th>
                        <th>Relative</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($this->profiles as $profile): ?>
                        <tr>
                            <td class=group colspan=4><a href='<?php echo $this->url.$profile['filename'] ?>'><?php echo $profile['title'] ?></a></td>
                        </tr>
                        <?php foreach($profile['results'] as $stats): ?>
                            <tr>
                                <td><a href='<?php echo $this->url.$profile['filename'] ?>#L<?php echo $stats['startLine'] ?>'><?php echo $this->highlight($stats['label']) ?></a></td>
                                <td><?php echo $stats['mean'] ?> s</td>
                                <td><?php echo $this->microformat($stats['single']) ?></td>
                                <td class='<?php echo ($stats['pc'] < 0) ? 'good' : 'bad' ?>'><?php if ($stats['pc'] > 0):?>+<?php endif; ?><?php echo round($stats['pc'], 2) ?> &#37;</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
