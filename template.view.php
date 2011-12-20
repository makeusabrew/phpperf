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
            <table class="zebra-striped bordered-table">
                <thead>
                    <tr>
                        <th>Method</th>
                        <th>1,000</th>
                        <th>1</th>
                        <th>Relative &#37;</th>
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
                                <td><?php echo $stats['mean'] ?></td>
                                <td><?php echo $stats['single'] ?></td>
                                <td>-</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
