<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/top_artists.php';

check_user_logged_in();


echo Template::render(
    'static/top_artists.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'top_artists' => top_artists(),
        'footer' => footer(),
        ]
);

?>