<?php

require_once 'php/classes/resources.php';

/* Output the complete 404 error page */
include 'php/components/header.php';
include 'php/components/footer.php';

http_response_code(404);

echo Template::render(
    'static/404.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
    ]
);
