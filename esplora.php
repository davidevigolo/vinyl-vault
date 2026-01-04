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

echo Template::render(
    'static/esplora.html',
    array_merge([
        'head' => Template::render('static/layout/head.html',[]),
        'header' => Template::render('static/layout/header.html',[]),
        'footer' => Template::render('static/layout/footer.html',[]),
        'recommended_vinyls' => $recommended,
        'loved_artists' => $loved_artists,
        'most_collected_vinyls' => $most_collected
    ], $album_week_data)
);
