<!doctype html>
<html>
    <head>
        <title>PHP Performance Charts</title>
    </head>
    <body>
        <table>
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
                        <td colspan=4><?php echo $group ?></td>
                    </tr>
                    <?php foreach($result as $label => $stats): ?>
                        <tr>
                            <td><?php echo $label ?></td>
                            <td><?php echo $stats['mean'] ?></td>
                            <td><?php echo $stats['single'] ?></td>
                            <td>-</td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
