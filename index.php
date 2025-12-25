<?php

require 'php/classes/resources.php';

/* Output the complete HTML page */
echo Template::render(
    '../../index.html',
    [
        'head' => Template::render('php/static/layout/head.html',[]),
        'header' => Template::render('php/static/layout/header.html',[])]
);