#!/usr/bin/php
<?php
class HtmlReporter {
    public function run() {
        $data = file_get_contents("php://stdin");
        $data = json_decode($data, true);
        echo $this->render("template.view.php", array(
            'profiles' => $data['profiles'],
            'meta' => $data['meta'],
            'url' => 'https://github.com/makeusabrew/phpperf/',
        ));
    }

    protected function highlight($str) {
        return str_replace("&lt;?php&nbsp;", "", highlight_string("<?php ".$str, true));
    }

    protected function microformat($value) {
        return (($value * 1000000))." &mu;s";
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
