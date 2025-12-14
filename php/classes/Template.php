<?php
class Template {
    public static function render($file, $vars) {
        $template = file_get_contents(__DIR__ . "/../static/" . $file);
        foreach ($vars as $key => $value) {
            $template = str_replace("[$key]", $value, $template);
        }
        return $template;
    }
}