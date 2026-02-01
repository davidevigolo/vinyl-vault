<?php

require_once 'php/classes/utils.php';
check_user_logged_in();

require_once 'php/classes/Template.php';
require_once 'php/components/header.php';
require_once 'php/components/footer.php';

require_once 'php/components/collection.php';
require_once 'php/components/wishlist.php';
require_once 'php/classes/DbConnection.php';

echo Template::render('static/profile.html', array_merge(
    user_info(),
    profile_statistics(),
    collection_cards(),
    wishlist_cards(),
    favorite_artists(),
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'footer' => footer(),
        'remove-propic-disabled' => ($_SESSION['propic_path'] ?? '') === 'assets/images/default-avatar.png' ? 'disabled="disabled"' : '',
    ]
));

function user_info() {
    return [
        'propic_path' => $_SESSION['propic_path'] ?? 'assets/images/default-avatar.png',
        'username' => htmlspecialchars($_SESSION['username']),
        'first_name' => htmlspecialchars($_SESSION['first_name']),
        'last_name' => htmlspecialchars($_SESSION['last_name']),
        'user_bio' => htmlspecialchars($_SESSION['bio'] ?? ''),
    ];
}

/* ottimizzata -> controllare
function profile_statistics() {
    $connection = DbConnection::get_instance();
    $user_id = intval($_SESSION['user_id']);

    // Count disks in collection
    $query_collection = "SELECT COUNT(*) as count FROM ownership WHERE user_id = $user_id";
    $result_collection = mysqli_query($connection->get_connection(), $query_collection);
    $collection_count = 0;
    if ($result_collection) {
        $row = mysqli_fetch_assoc($result_collection);
        $collection_count = $row['count'];
    }

    // Count disks in wishlist
    $query_wishlist = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = $user_id";
    $result_wishlist = mysqli_query($connection->get_connection(), $query_wishlist);
    $wishlist_count = 0;
    if ($result_wishlist) {
        $row = mysqli_fetch_assoc($result_wishlist);
        $wishlist_count = $row['count'];
    }

    // Count unique artists in collection
    $query_artists = "SELECT COUNT(DISTINCT a.id) as count 
                     FROM ownership o 
                     JOIN disk d ON o.disk_id = d.id 
                     JOIN disk_author_release dar ON d.id = dar.disk_id 
                     JOIN author a ON dar.author_id = a.id 
                     WHERE o.user_id = $user_id";
    $result_artists = mysqli_query($connection->get_connection(), $query_artists);
    $artists_count = 0;
    if ($result_artists) {
        $row = mysqli_fetch_assoc($result_artists);
        $artists_count = $row['count'];
    }

    return [
        'collection-disk-count' => htmlspecialchars($collection_count),
        'wishlist-disk-count' => htmlspecialchars($wishlist_count),
        'collection-artist-count' => htmlspecialchars($artists_count)
    ];
}*/
function profile_statistics() {
    $connection = DbConnection::get_instance();
    $user_id = intval($_SESSION['user_id']);

    // Una singola query per ottenere tutti e tre i conteggi contemporaneamente
    $query = "SELECT 
        (SELECT COUNT(*) FROM ownership WHERE user_id = $user_id) as collection_count,
        (SELECT COUNT(*) FROM wishlist WHERE user_id = $user_id) as wishlist_count,
        (SELECT COUNT(DISTINCT dar.author_id) 
         FROM ownership o 
         JOIN disk_author_release dar ON o.disk_id = dar.disk_id 
         WHERE o.user_id = $user_id) as artists_count";

    $result = mysqli_query($connection->get_connection(), $query);
    
    $stats = [
        'collection-disk-count' => 0,
        'wishlist-disk-count' => 0,
        'collection-artist-count' => 0
    ];

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $stats['collection-disk-count'] = $row['collection_count'];
        $stats['wishlist-disk-count'] = $row['wishlist_count'];
        $stats['collection-artist-count'] = $row['artists_count'];
    }

    return $stats;
}

function collection_cards() {
    $collection = get_collection();

    if (!$collection || mysqli_num_rows($collection) === 0) {
        return ['collection' => Template::render('static/layout/profile/empty_profile_collection.html', [])];
    }

    $items = '';
    $i = 0;
    while (($vinyl = mysqli_fetch_assoc($collection)) && $i < 4) {
        $i++;
        // TODO: Usare image_path quando le immagini saranno caricate
        $items .= Template::render('static/layout/vinyl_card.html', [
            'title' => htmlspecialchars($vinyl['title']),
            'artist' => htmlspecialchars($vinyl['author']),
            'ed_name' => htmlspecialchars($vinyl['edition_name']),
            'ed_name_url' => urlencode($vinyl['edition_name']),
            'nationality' => htmlspecialchars(get_nationality_languages()[strtolower($vinyl['country'])]),
            'cover_image' => htmlspecialchars($vinyl['image_path']) ?: 'assets/images/vinyl_placeholder.jpg',
            'disk_id' => htmlspecialchars($vinyl['disk_id'])
        ]);
    }

    return ['collection' => $items];
}

function wishlist_cards() {
    $wishlist = get_wishlist();

    if (!$wishlist || mysqli_num_rows($wishlist) === 0) {
        return ['wishlist' => Template::render('static/layout/profile/empty_profile_wishlist.html', [])];
    }

    $items = '';
    $i = 0;
    while (($vinyl = mysqli_fetch_assoc($wishlist)) && $i < 4) {
        $i++;
        // TODO: Usare image_path quando le immagini saranno caricate
        $items .= Template::render('static/layout/vinyl_card.html', [
            'title' => htmlspecialchars($vinyl['title']),
            'artist' => htmlspecialchars($vinyl['author']),
            'ed_name' => htmlspecialchars($vinyl['edition_name']),
            'ed_name_url' => urlencode($vinyl['edition_name']),
            'nationality' => htmlspecialchars(get_nationality_languages()[strtolower($vinyl['country'])]),
            'cover_image' => htmlspecialchars($vinyl['image_path']) ?: 'assets/images/vinyl_placeholder.jpg',
            'disk_id' => htmlspecialchars($vinyl['disk_id'])
        ]);
    }

    return ['wishlist' => $items];
}

function favorite_artists() {
    $connection = DbConnection::get_instance();
    $user_id = intval($_SESSION['user_id']);

    // Get top 3 artists by number of disks owned
    $query = "SELECT a.id, a.author_name, a.image_path, COUNT(DISTINCT o.disk_id) as disk_count
              FROM ownership o
              JOIN disk d ON o.disk_id = d.id
              JOIN disk_author_release dar ON d.id = dar.disk_id
              JOIN author a ON dar.author_id = a.id
              WHERE o.user_id = $user_id
              GROUP BY a.id, a.author_name, a.image_path
              ORDER BY disk_count DESC, a.author_name ASC
              LIMIT 4";

    $result = mysqli_query($connection->get_connection(), $query);

    // If no artists, render empty state
    if (!$result || mysqli_num_rows($result) === 0) {
        return ['favorite-artists-content' => Template::render('static/layout/profile/empty_favorite_artists.html', [])];
    }

    // Build list items only for artists that exist
    $artists_html = '';
    while ($artist = mysqli_fetch_assoc($result)) {
        $disk_text = $artist['disk_count'] == 1 ? '1 disco' : $artist['disk_count'] . ' dischi';
        $image = $artist['image_path'] ? htmlspecialchars($artist['image_path']) : 'assets/images/default-artist.png';

        $artists_html .= Template::render('static/layout/profile/favorite_artist_item.html', [
            'artist-id' => htmlspecialchars($artist['id']),
            'artist-name' => htmlspecialchars($artist['author_name']),
            'artist-image' => $image,
            'artist-disk-count' => htmlspecialchars($disk_text)
        ]);
    }

    return ['favorite-artists-content' => '<ol class="favorite-artists-list">' . $artists_html . '</ol>'];
}