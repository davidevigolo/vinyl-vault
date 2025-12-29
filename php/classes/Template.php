<?php
class Template {
    /**
     * Renders a template file by replacing placeholders with provided values.
     *
     * This method loads a template file from the static directory and replaces
     * all placeholders in the format [key] with their corresponding values from
     * the provided associative array.
     *
     * @param string $file The template file name relative to the php/static directory
     * @param array<string, string> $vars Associative array where keys (without brackets) are placeholder names
     *                                     and values are the replacement strings
     * 
     * @return string The rendered template with all placeholders replaced
     * 
     */
    public static function render($file, $vars) {
        $template = file_get_contents(__DIR__ . "/../" . $file);
        foreach ($vars as $key => $value) {
            $template = str_replace("[$key]", $value, $template);
        }
        return $template;
    }
}