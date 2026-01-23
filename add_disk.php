<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_disk_form.php';

check_user_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $artist = $_POST['artist'] ?? null;
    $type = $_POST['type'] ?? null;
    $genres = $_POST['genre'] ?? null;
    $genres = array_filter($genres, fn($value) => trim($value) !== '');

    include_once 'php/controllers/add_disk_controller.php';
    $result = add_disk_to_collection($title, $artist, $type, $genres);
    if ($result['success']) {
        echo Template::render('static/layout/add_disk/add_disk_success.html', []);
        exit();
    }

    echo Template::render(
        'static/add_disk.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_disk_form' => add_disk_form($title, $artist, $type, $genres, $result['error'] ? [$result['error']] : []),
            'footer' => footer(),
            'validation_scripts' => get_validation_scripts(['add_disk.js'])
        ]
    );
    exit();
}

$result = isset($_GET['result']) ? $_GET['result'] : false;
echo Template::render(
    'static/add_disk.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_disk_form' => add_disk_form('', '', '', [], []),
        'footer' => footer(),
        'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_disk.js'])
    ]
);