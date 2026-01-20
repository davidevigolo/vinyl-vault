<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_edition_form.php';

check_user_logged_in();

$result = isset($_GET['result']) ? $_GET['result'] : false;
echo Template::render(
    'static/add_edition.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'add_edition_form' => add_edition_form($result),
        'footer' => footer(),
        'validation_scripts' => $result === 'success' ? '' : get_validation_scripts(['add_edition.js', 'photo_validator.js'])
        ]
);