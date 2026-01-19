<?php

require 'php/classes/resources.php';

$disk_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$disk_id) {
    header('Location: index.php');
    exit;
}

include 'php/components/album_info.php';
include 'php/components/album_tracklist.php';
include 'php/components/album_versions.php';
include 'php/components/album_credits.php';
include 'php/components/header.php';
include 'php/components/footer.php';

$album_data = get_album_info($disk_id);

if (!$album_data) {
    header('Location: index.php');
    exit;
}

$album_image = !empty($album_data['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $album_data['image_path'])
    ? $album_data['image_path']
    : 'assets/images/pollo.webp';

echo Template::render(
    'static/album.html',
    [
        'head' => Template::render('static/layout/head.html',['title' => htmlspecialchars($album_data['title']) . ' - ' . htmlspecialchars($album_data['artist_name']) . ' | Vinyl Vault']),
        'header' => _header(),
        'footer' => footer(),
        'album_title' => htmlspecialchars($album_data['title']),
        'artist_name' => htmlspecialchars($album_data['artist_name']),
        'artist_id' => $album_data['artist_id'],
        'album_image' => htmlspecialchars($album_image),
        'release_year' => $album_data['release_year'],
        'disk_type' => htmlspecialchars($album_data['disk_type']),
        'album_genres' => get_album_genres($disk_id),
        'average_rating' => number_format($album_data['avg_rating'], 1),
        'review_count' => $album_data['review_count'],
        'album_tracklist' => album_tracklist($disk_id),
        'album_versions' => album_versions($disk_id),
        'album_credits' => album_credits($disk_id)
    ]
);
