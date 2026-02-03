<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_edition_form.php';

check_user_logged_in();
check_user_is_admin();

if(isset($_SESSION['add_edition_result']['success']) && $_SESSION['add_edition_result']['success']) {
    unset($_SESSION['add_edition_result']);
    echo Template::render(
        'static/add_edition.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_edition_form' => Template::render('static/layout/add_edition/add_edition_success.html', []),
            'footer' => footer(),
            'validation_scripts' => ''
        ]
    );
    exit();
}

$disk_id = $_SESSION['add_edition_result']['disk'] ?? '';
$name = $_SESSION['add_edition_result']['name'] ?? '';
$release_date = $_SESSION['add_edition_result']['release_date'] ?? '';
$country = $_SESSION['add_edition_result']['country'] ?? '';
$is_standard_edition = $_SESSION['add_edition_result']['is_standard_edition'] ?? false;
$errors = isset($_SESSION['add_edition_result']['error']) ? [$_SESSION['add_edition_result']['error']] : [];
unset($_SESSION['add_edition_result']);
echo Template::render(
    'static/add_edition.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_edition_form' => add_edition_form($disk_id, $name, $release_date, $country, $is_standard_edition, $errors),
        'footer' => footer(),
        'validation_scripts' => get_validation_scripts(['add_edition.js', 'photo_validator.js'])
    ]
);