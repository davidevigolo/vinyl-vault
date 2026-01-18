<?php
include_once 'php/classes/DbConnection.php';

function get_album_of_week()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT ed.disk_id, ed.edition_name, d.title, au.author_name, au.id as author_id, 
                     ed.image_path, COUNT(o.user_id) as ownership_count
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

function album_of_week()
{
    $album = get_album_of_week();
    
    if (!$album) {
        // Fallback se non ci sono dati
        return [
            'album_week_image' => 'assets/images/pollo.webp',
            'album_week_title' => 'TBD - Nessun album disponibile',
            'album_week_artist' => 'N/A',
            'album_week_description' => 'TBD - TEMPORANEO - DA IMPLEMENTARE',
            'album_week_id' => '#',
            'album_week_edition' => ''
        ];
    }
    
    // TBD: Implementare gestione immagini reali
    $cover_image = 'assets/images/pollo.webp';
    
    $description = sprintf(
        "Il vinile di questa settimana è <strong>%s</strong> di <strong>%s</strong>",
        htmlspecialchars($album['title']),
        htmlspecialchars($album['author_name'])
    );
    
    return [
        'album_week_image' => $cover_image,
        'album_week_title' => htmlspecialchars($album['title']),
        'album_week_artist' => htmlspecialchars($album['author_name']),
        'album_week_description' => $description,
        'album_week_id' => $album['disk_id'],
        'album_week_edition' => htmlspecialchars($album['edition_name'])
    ];
}
