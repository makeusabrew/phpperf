#!/usr/bin/php
<?php
class HtmlReporter {
    public function run() {
        //$fp = fopen("php://stdin", "r");
        $data = file_get_contents("php://stdin");
        $results = json_decode($data, true);
        echo $this->render("template.view.php", array('results' => $results));
    }

    protected function highlight($str) {
        return str_replace("&lt;?php&nbsp;", "", highlight_string("<?php ".$str, true));
    }

    public function render($tpl, $vars) {
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
