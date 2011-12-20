#!/usr/bin/php
<?php
class HtmlReporter {
    public function run() {
        $data = file_get_contents("php://stdin");
        $data = json_decode($data, true);
        echo $this->render("template.view.php", array(
            'results' => $data['results'],
            'meta' => $data['meta'],
        ));
    }

    protected function highlight($str) {
        return str_replace("&lt;?php&nbsp;", "", highlight_string("<?php ".$str, true));
    }

    protected function microformat($value) {
        $offsets = array(
            "second ",
            "tenth of a second ",
            "hundreth of a second ",
            "millisecond ",
            "nanosecond ",
            "picosecond ",
            "femtosecond "
        );
        return round(($value * 1000000), 3)." &mu;s";
        /*
        if (preg_match("/^0\.0*([1-9])/", $value, $matches, PREG_OFFSET_CAPTURE)) {
            $offset = $matches[1][1] - 1;
            $string = $offsets[$offset];
            $value = $matches[1][0];
            if ($value > 1) {
                $count = 1;
                $string = str_replace(" ", "s ", $string, $count);
            }
            return $value." ".substr($string, 0, -1);
        }
        */
        return $value;
    }

    protected function render($tpl, $vars) {
        foreach ($vars as $k => $v) {
            $this->$k = $v;
        }
        ob_start();
        include($tpl);
        return ob_get_clean();
    }
}

$reporter = new HtmlReporter();
$reporter->run();
