<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/wishlist.php';

check_user_logged_in();

$edit_mode = isset($_GET['edit']) ? $_GET['edit'] : false;
echo Template::render(
    $edit_mode ? 'static/wishlist_edit.html' : 'static/wishlist.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'wishlist' => wishlist($edit_mode),
        'footer' => footer(),
    ]
);