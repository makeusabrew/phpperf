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
        <div class=container>
            <div class='page-header'>
                <h1>PHP Performance Metrics</h1>
            </div>

            <p>Each test comprises of <strong><?php echo number_format($this->meta['iterations']) ?></strong> method calls
            averaged over <strong><?php echo $this->meta['repetitions'] ?></strong> repetitions.</p>
            <p>The mean profile time takes <strong><?php echo $this->meta['mean'] ?> seconds</strong> to run the average method <?php echo number_format($this->meta['iterations']) ?> times.</p>

            <h2>Units</h2>

            <p><strong>&mu;s</strong> &ndash; microsecond. It takes roughly 350,000 of these for you to blink your eye.</p>

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
