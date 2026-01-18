<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/add_artist_form.php';

check_user_logged_in();

$edit_mode = isset($_GET['edit']) ? $_GET['edit'] : false;
echo Template::render(
    $edit_mode ? 'static/add_artist.html' : 'static/add_artist.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'add_artist_form' => add_artist_form(),
        'footer' => footer(),
        ]
);