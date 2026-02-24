<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_disk_form.php';

check_user_logged_in();
check_user_is_admin();

if (isset($_SESSION['add_disk_result']['success']) && $_SESSION['add_disk_result']['success']) {
    unset($_SESSION['add_disk_result']);
    echo Template::render(
        'static/add_disk.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_disk_form' => Template::render('static/layout/add_disk/add_disk_success.html', []),
            'footer' => footer(),
            'validation_scripts' => ''
        ]
    );
    exit();
}

$title = $_SESSION['add_disk_result']['title'] ?? '';
$artist = $_SESSION['add_disk_result']['artist'] ?? '';
$type = $_SESSION['add_disk_result']['type'] ?? '';
$label = $_SESSION['add_disk_result']['label'] ?? '';
$genres = $_SESSION['add_disk_result']['genres'] ?? [];
$errors = isset($_SESSION['add_disk_result']['error']) ? [$_SESSION['add_disk_result']['error']] : [];
unset($_SESSION['add_disk_result']);

echo Template::render(
    'static/add_disk.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_disk_form' => add_disk_form($title, $artist, $type, $label, $genres, $errors),
        'footer' => footer(),
        'validation_scripts' => get_validation_scripts(['add_disk.js'])
    ]
);