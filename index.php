<?php

require 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/trending_vinyls.php';
$trending_vinyls = trending_vinyls();
echo Template::render(
    'static/index.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => Template::render('static/layout/header.html',[]),
        'trending_vinyls' => $trending_vinyls]
);