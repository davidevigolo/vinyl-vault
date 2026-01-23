<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_tracks_form.php';

check_user_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disk = $_POST['disk'] ?? null;
    $edition = $_POST['edition'] ?? null;
    $titles = $_POST['title'] ?? [];
    $durations = $_POST['duration'] ?? [];

    $titles = array_filter($titles, fn($value) => trim($value) !== '');
    $durations = array_filter($durations, fn($value) => trim($value) !== '');

    include_once 'php/controllers/add_tracks_controller.php';
    $result = add_tracks($disk, $edition, $titles, $durations);
    if ($result['success']) {
        echo Template::render(
        'static/add_tracks.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_tracks_form' => Template::render('static/layout/add_tracks/add_tracks_success.html', []),
            'footer' => footer(),
            'validation_scripts' => get_validation_scripts(['add_tracks.js'])
        ]
    );
        exit();
    }

    echo Template::render(
        'static/add_tracks.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_tracks_form' => add_tracks_form($disk, $edition, $titles, $durations, $result['error'] ? [$result['error']] : []),
            'footer' => footer(),
            'validation_scripts' => get_validation_scripts(['add_tracks.js'])
        ]
    );
    exit();
}

$result = isset($_GET['result']) ? $_GET['result'] : false;
echo Template::render(
    'static/add_tracks.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_tracks_form' => $result ? Template::render('static/layout/add_tracks/add_tracks_success.html', []) : add_tracks_form('', '', [], [], []),
        'footer' => footer(),
        'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_tracks.js'])
    ]
);