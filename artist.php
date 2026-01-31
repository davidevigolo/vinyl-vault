<?php

require 'php/classes/resources.php';

$artist_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$artist_id) {
    header('Location: index.php');
    exit;
}

include 'php/components/artist_info.php';
include 'php/components/artist_albums.php';
include 'php/components/artist_singles.php';
include 'php/components/similar_artists.php';
include 'php/components/header.php';
include 'php/components/footer.php';

$artist_data = get_artist_info($artist_id);

if (!$artist_data) {
    header('Location: index.php');
    exit;
}

//echo $artist_data['image_path'];

$artist_image = !empty($artist_data['image_path'])
    ? $artist_data['image_path']
    : 'assets/images/pollo.webp';

//echo $artist_image;

echo Template::render(
    'static/artist.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
        'artist_name' => htmlspecialchars($artist_data['author_name']),
        'artist_image' => htmlspecialchars($artist_image),
        'artist_genres' => get_artist_genres($artist_id),
        'artist_albums' => artist_albums($artist_id),
        'artist_singles' => artist_singles($artist_id),
        'similar_artists' => similar_artists($artist_id)
    ]
);
