<?php

require_once 'php/classes/resources.php';

/* Output the complete 403 error page */
include 'php/components/header.php';
include 'php/components/footer.php';

http_response_code(403);

echo Template::render(
    'static/403.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
    ]
);
