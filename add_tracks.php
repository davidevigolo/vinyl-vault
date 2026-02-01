<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_tracks_form.php';

check_user_logged_in();

if(isset($_SESSION['add_tracks_result']['success']) && $_SESSION['add_tracks_result']['success']) {
    unset($_SESSION['add_tracks_result']);
    echo Template::render(
        'static/add_tracks.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_tracks_form' => Template::render('static/layout/add_tracks/add_tracks_success.html', []),
            'footer' => footer(),
            'validation_scripts' => ''
        ]
    );
    exit();
}

if(isset($_GET) && isset($_GET['disk']) && isset($_GET['edition'])) {
    $_SESSION['add_tracks_result']['disk'] = $_GET['disk'];
    $_SESSION['add_tracks_result']['edition'] = $_GET['edition'];
}

$disk = $_SESSION['add_tracks_result']['disk'] ?? '';
$edition = $_SESSION['add_tracks_result']['edition'] ?? '';
$titles = $_SESSION['add_tracks_result']['titles'] ?? [];
$durations = $_SESSION['add_tracks_result']['durations'] ?? [];
$errors = isset($_SESSION['add_tracks_result']['error']) ? [$_SESSION['add_tracks_result']['error']] : [];
unset($_SESSION['add_tracks_result']);
echo Template::render(
    'static/add_tracks.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_tracks_form' => add_tracks_form($disk, $edition, $titles, $durations, $errors),
        'footer' => footer(),
        'validation_scripts' => get_validation_scripts(['add_tracks.js'])
    ]
);