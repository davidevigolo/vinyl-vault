<?php
require 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/wishlist.php';

echo Template::render(
    'static/wishlist.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'wishlist' => wishlist(),
        'footer' => footer(),
        ]
);

?>