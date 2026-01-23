<?php
include_once 'php/classes/Template.php';
include_once 'php/classes/utils.php';

function add_artist_form($name, $nationality, $errors): string
{
    $form_html = file_get_contents(__DIR__ . '/../static/layout/add_artist/add_artist_form.html');
    $nationality_codes = get_nationality_codes();
    return Template::render('static/layout/add_artist/add_artist_form.html', [
        'name' => isset($name) ? htmlspecialchars($name) : '',
        'nationality_options' => implode('', array_map(function ($code, $country) use ($nationality) {
            $selected = ($code === $nationality) ? ' selected' : '';
            return '<option value="' . htmlspecialchars($code) . '"' . $selected . '>' . htmlspecialchars($country) . '</option>';
        }, array_keys($nationality_codes), array_values($nationality_codes))),
        'errors' => isset($errors) && !empty($errors) ? '<ul>' . implode('', array_map(fn($error) => '<li>' . htmlspecialchars($error) . '</li>', $errors)) . '</ul>' : ''
    ]);
}