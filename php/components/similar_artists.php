<?php
include_once 'php/classes/DbConnection.php';

function similar_artists($artist_id)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT DISTINCT a.id, a.author_name, a.image_path
              FROM author a
              JOIN disk_author_release dar ON a.id = dar.author_id
              JOIN disk_genre_classification dgc2 ON dar.disk_id = dgc2.disk_id
              WHERE a.id != ? 
              AND dgc2.genre_name IN (
                  SELECT DISTINCT dgc.genre_name
                  FROM disk_genre_classification dgc
                  JOIN disk_author_release dar2 ON dgc.disk_id = dar2.disk_id
                  WHERE dar2.author_id = ?
              )
              GROUP BY a.id, a.author_name, a.image_path
              ORDER BY RAND()
              LIMIT 3";
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection->get_connection()));
        return '<p>Nessun artista simile disponibile.</p>';
    }
    mysqli_stmt_bind_param($stmt, 'ii', $artist_id, $artist_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '<p>Nessun artista simile disponibile.</p>';
    }
    
    ob_start();
    if (mysqli_num_rows($result) > 0) {
        while ($artist = mysqli_fetch_assoc($result)) {
            $image = !empty($artist['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $artist['image_path'])
                ? $artist['image_path']
                : 'assets/images/pollo.webp';
            
            echo Template::render('static/layout/most_liked_artists_card.html', [
                'artist_id' => $artist['id'],
                'artist_name' => htmlspecialchars($artist['author_name']),
                'image_path' => htmlspecialchars($image)
            ]);
        }
    } else {
        echo '<p>Nessun artista simile disponibile.</p>';
    }
    
    mysqli_stmt_close($stmt);
    return ob_get_clean();
}
