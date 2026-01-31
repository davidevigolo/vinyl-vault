<?php
class Template {
    /*
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
    // Array statico che fungerà da memoria temporanea per i file caricati
    //private static $cache = [];

    /**
     * Renders a template file by replacing placeholders with provided values.
     * Con ottimizzazione del caricamento tramite cache statica.
     *//*
    public static function render($file, $vars) {
        $filePath = __DIR__ . "/../" . $file;

        // Se il file non è ancora stato letto in questa esecuzione, lo leggiamo ora
        if (!isset(self::$cache[$file])) {
            if (file_exists($filePath)) {
                self::$cache[$file] = file_get_contents($filePath);
            } else {
                // Gestione errore se il file non esiste
                error_log("Template non trovato: " . $filePath);
                return "Errore: template non trovato.";
            }
        }

        // Recuperiamo il contenuto dalla cache
        $template = self::$cache[$file];

        // Sostituiamo i segnaposto
        foreach ($vars as $key => $value) {
            $template = str_replace("[$key]", $value, $template);
        }

        return $template;
    }
}*/