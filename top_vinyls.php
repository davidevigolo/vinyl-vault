<?php
require_once 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/header.php';
include 'php/components/footer.php';
include 'php/components/top_vinyls.php';


echo Template::render(
    'static/top_vinyls.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'top_vinyls' => top_vinyls(),
        'footer' => footer(),
        ]
);

?>