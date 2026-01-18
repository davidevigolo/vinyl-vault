<?php
include_once 'php/classes/DbConnection.php';

function artist_albums($artist_id)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT d.id as disk_id, d.title, e.edition_name, e.image_path,
                     a.author_name, a.id as author_id
              FROM disk d
              JOIN disk_author_release dar ON d.id = dar.disk_id
              JOIN edition e ON d.id = e.disk_id
              JOIN author a ON dar.author_id = a.id
              WHERE dar.author_id = ? AND d.disk_type = 'ALBUM'
              ORDER BY e.release_date DESC";
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return '<p>Nessun album disponibile.</p>';
    }
    mysqli_stmt_bind_param($stmt, 'i', $artist_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        return '<p>Nessun album disponibile.</p>';
    }
    
    ob_start();
    if (mysqli_num_rows($result) > 0) {
        while ($album = mysqli_fetch_assoc($result)) {
            $image = !empty($album['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $album['image_path']) 
                ? $album['image_path'] 
                : 'assets/images/pollo.webp';
            
            echo Template::render('static/layout/vinyl_card.html', [
                'disk_id' => $album['disk_id'],
                'ed_name' => htmlspecialchars($album['edition_name']),
                'title' => htmlspecialchars($album['title']),
                'artist' => htmlspecialchars($album['author_name']),
                'cover_image' => htmlspecialchars($image)
            ]);
        }
    } else {
        echo '<p>Nessun album disponibile.</p>';
    }
    
    mysqli_stmt_close($stmt);
    return ob_get_clean();
}
