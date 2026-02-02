<?php
include_once 'php/classes/DbConnection.php';

function get_album_of_week() {
    $connection = DbConnection::get_instance();
    $query = "SELECT ed.disk_id, ed.edition_name, d.title, au.author_name, au.id as author_id, 
                     ed.image_path, COUNT(o.user_id) as ownership_count, au.nationality
              FROM ownership as o
              JOIN edition as ed ON o.disk_id = ed.disk_id AND o.edition_name = ed.edition_name
              JOIN disk as d ON d.id = ed.disk_id
              JOIN disk_author_release as dar ON dar.disk_id = ed.disk_id
              JOIN author as au ON au.id = dar.author_id
              GROUP BY ed.disk_id, ed.edition_name, d.title, au.author_name, au.id, ed.image_path
              ORDER BY ownership_count DESC
              LIMIT 1;";
    
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return mysqli_fetch_assoc($result);
}

function album_of_week() {
    $album = get_album_of_week();
    
    if (!$album) {
        return [
            'album_week_image' => 'assets/images/vinyl_placeholder.jpg',
            'album_week_title' => 'Nessun album disponibile',
            'album_week_artist' => 'Artista sconosciuto',
            'album_week_description' => 'Al momento non ci sono abbastanza dati per determinare l\'album della settimana.',
            'album_week_id' => '#',
            'album_week_edition' => ''
        ];
    }
    
    $cover_image = htmlspecialchars($album['image_path']) ?: 'assets/images/vinyl_placeholder.jpg';
    
    $nationality_languages = get_nationality_languages();
    $lang = $nationality_languages[$album['nationality']] ?? 'en';

    $description = sprintf(
        "Il vinile di questa settimana è <strong><span lang=\"%s\">%s</span></strong> di <strong><span lang=\"%s\">%s</span></strong>",
        htmlspecialchars($lang),
        htmlspecialchars($album['title']),
        htmlspecialchars($lang),
        htmlspecialchars($album['author_name'])
    );
    
    return [
        'album_week_image' => $cover_image,
        'album_week_title' => htmlspecialchars($album['title']),
        'album_week_artist' => htmlspecialchars($album['author_name']),
        'album_week_description' => $description,
        'album_week_id' => $album['disk_id'],
        'album_week_edition' => htmlspecialchars($album['edition_name']),
        'album_week_edition_url' => urlencode($album['edition_name'])
    ];
}
