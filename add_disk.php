<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_disk_form.php';

check_user_logged_in();

$edit_mode = isset($_GET['edit']) ? $_GET['edit'] : false;
echo Template::render(
    $edit_mode ? 'static/add_disk.html' : 'static/add_disk.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'add_disk_form' => add_disk_form(),
        'footer' => footer(),
        ]
);