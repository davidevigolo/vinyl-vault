<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_artist_form.php';

check_user_logged_in();

if (isset($_SESSION['add_artist_result']['success']) && $_SESSION['add_artist_result']['success']) {
    unset($_SESSION['add_artist_result']);
    echo Template::render(
        'static/add_artist.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_artist_form' => Template::render('static/layout/add_artist/add_artist_success.html', []),
            'footer' => footer(),
            'validation_scripts' => ''
        ]
    );
    exit();
}

$name = $_SESSION['add_artist_result']['name'] ?? '';
$nationality = $_SESSION['add_artist_result']['nationality'] ?? '';
$errors = isset($_SESSION['add_artist_result']['error']) ? [$_SESSION['add_artist_result']['error']] : [];
unset($_SESSION['add_artist_result']);

echo Template::render(
    'static/add_artist.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_artist_form' => add_artist_form($name, $nationality, $errors),
        'footer' => footer(),
        'validation_scripts' => get_validation_scripts(['add_artist.js'])
    ]
);