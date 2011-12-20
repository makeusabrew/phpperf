<!doctype html>
<html>
    <head>
        <title>PHP Performance Charts</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
        <style>
            td.group {
                font-weight:bold;
            }
        </style>
    </head>
    <body>
        <div class=container>
            <div class='page-header'>
                <h1>PHP Performance Metrics</h1>
            </div>

            <p>Each test comprises of <strong><?php echo number_format($this->meta['iterations']) ?></strong>
            averaged over <strong><?php echo $this->meta['repetitions'] ?></strong> repetitions.</p>
            <p>The mean profile time takes <strong><?php echo $this->meta['mean'] ?> seconds</strong> to run the average method <?php echo number_format($this->meta['iterations']) ?>.</p>

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
                    <?php foreach($this->results as $group => $result): ?>
                        <tr>
                            <td class=group colspan=4><?php echo $group ?></td>
                        </tr>
                        <?php foreach($result as $stats): ?>
                            <tr>
                                <td><?php echo $this->highlight($stats['label']) ?></td>
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
