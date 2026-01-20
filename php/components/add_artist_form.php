<?php
include_once 'php/classes/Template.php';
include_once 'php/classes/utils.php';

function add_artist_form($result)
{
    if ($result === 'success') {
        return Template::render('static/layout/add_artist/add_artist_success.html', []);
    } else {
        $form_html = file_get_contents(__DIR__ . '/../static/layout/add_artist/add_artist_form.html');
        $nationality_codes = get_nationality_codes();
        return Template::render('static/layout/add_artist/add_artist_form.html', [
            'nationality_options' => implode('', array_map(function ($code, $country) {
                return '<option value="' . htmlspecialchars($code) . '">' . htmlspecialchars($country) . '</option>';
            }, array_keys($nationality_codes), array_values($nationality_codes))),
        ]);
    }
}