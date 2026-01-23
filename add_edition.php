<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_edition_form.php';

check_user_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $release_date = $_POST['release-date'] ?? null;
    $disk_id = $_POST['disk'] ?? null;
    $name = $_POST['name'] ?? null;
    $country = $_POST['country'] ?? null;
    $image = $_FILES['photo'] ?? null;
    $is_standard_edition = isset($_POST['standard-edition']);

    include_once 'php/controllers/add_edition_controller.php';
    $result = add_edition($disk_id, $name, $release_date, $country, $is_standard_edition, $image);
    if ($result['success']) {
        echo Template::render(
            'static/add_edition.html',
            [
                'head' => Template::render('static/layout/head.html', []),
                'header' => _header(),
                'add_edition_form' => Template::render('static/layout/add_edition/add_edition_success.html', []),
                'footer' => footer(),
                'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_edition.js', 'photo_validator.js'])
            ]
        );
        exit();
    }

    echo Template::render(
        'static/add_edition.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_edition_form' => add_edition_form($disk_id, $name, $release_date, $country, $is_standard_edition, $result['error'] ? [$result['error']] : []),
            'footer' => footer(),
            'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_edition.js', 'photo_validator.js'])
        ]
    );
    exit();
}
$result = isset($_GET['result']) ? $_GET['result'] : false;
echo Template::render(
    'static/add_edition.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_edition_form' => $result ? Template::render('static/layout/add_edition/add_edition_success.html', []) : add_edition_form('', '', '', '', false, []),
        'footer' => footer(),
        'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_edition.js', 'photo_validator.js'])
    ]
);