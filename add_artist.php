<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_artist_form.php';

check_user_logged_in();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $nationality = $_POST['nationality'] ?? null;
    $image = $_FILES['photo'] ?? null;

    include_once 'php/controllers/add_artist_controller.php';
    $result = add_artist($name, $nationality, $image);
    if ($result['success']) {
        echo Template::render(
            'static/add_artist.html',
            [
                'head' => Template::render('static/layout/head.html', []),
                'header' => _header(),
                'add_artist_form' => Template::render('static/layout/add_artist/add_artist_success.html', []),
                'footer' => footer(),
                'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_artist.js'])
            ]
        );
        exit();
    }

    $name = $result['fields_to_reset'] && in_array('name', $result['fields_to_reset']) ? '' : $name;
    $nationality = $result['fields_to_reset'] && in_array('nationality', $result['fields_to_reset']) ? '' : $nationality;

    echo Template::render(
        'static/add_artist.html',
        [
            'head' => Template::render('static/layout/head.html', []),
            'header' => _header(),
            'add_artist_form' => add_artist_form($name, $nationality, $result['error'] ? [$result['error']] : []),
            'footer' => footer(),
            'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_artist.js'])
        ]
    );
    exit();
}

$result = isset($_GET['result']) ? $_GET['result'] : false;
echo Template::render(
    'static/add_artist.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'add_artist_form' => $result ? Template::render('static/layout/add_artist/add_artist_success.html', []) : add_artist_form('', '', []),
        'footer' => footer(),
        'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_artist.js'])
    ]
);