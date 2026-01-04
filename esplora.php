<?php

require 'php/classes/resources.php';

include 'php/components/album_of_week.php';
$album_week_data = album_of_week();

include 'php/components/recommended_vinyls.php';
$recommended = recommended_vinyls();

include 'php/components/most_liked_artists.php';
$loved_artists = most_liked_artists();

include 'php/components/most_collected_vinyls.php';
$most_collected = most_collected_vinyls();

include 'php/components/header.php';
include 'php/components/footer.php';

echo Template::render(
    'static/esplora.html',
    array_merge([
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
        'recommended_vinyls' => $recommended,
        'loved_artists' => $loved_artists,
        'most_collected_vinyls' => $most_collected
    ], $album_week_data)
);
