<?php

require 'php/classes/resources.php';

/* Output the complete HTML page */
include 'php/components/trending_vinyls.php';
include 'php/components/most_liked_artists.php';
include 'php/components/header.php';
include 'php/components/footer.php';

echo Template::render(
    'static/index.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'trending_vinyls' => trending_vinyls(),
        'banner_cta' => isset($_SESSION['user_id']) ? '' : Template::render('static/layout/index/banner_cta.html', []),
        'most_liked_artists' => most_liked_artists(),
        'footer' => footer(),
    ]
);