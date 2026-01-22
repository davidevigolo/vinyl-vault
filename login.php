<?php

require "php/classes/resources.php";

include "php/components/header.php";
include "php/components/footer.php";

echo Template::render(
    'static/login.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
    ]
);