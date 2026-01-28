<?php
include_once 'php/classes/DbConnection.php';

function artist_singles($artist_id)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT d.id as disk_id, d.title, e.edition_name, e.image_path,
                     a.author_name, a.id as author_id
              FROM disk d
              JOIN disk_author_release dar ON d.id = dar.disk_id
              JOIN edition e ON d.id = e.disk_id
              JOIN author a ON dar.author_id = a.id
              WHERE dar.author_id = ? AND d.disk_type IN ('SINGLE', 'EP')
              ORDER BY e.release_date DESC";
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return '<p>Nessun singolo o EP disponibile.</p>';
    }
    mysqli_stmt_bind_param($stmt, 'i', $artist_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        return '<p>Nessun singolo o EP disponibile.</p>';
    }
    
    ob_start();
    if (mysqli_num_rows($result) > 0) {
        while ($single = mysqli_fetch_assoc($result)) {
            
            echo Template::render('static/layout/vinyl_card.html', [
                'disk_id' => $single['disk_id'],
                'ed_name' => htmlspecialchars($single['edition_name']),
                'title' => htmlspecialchars($single['title']),
                'artist' => htmlspecialchars($single['author_name']),
                'cover_image' => htmlspecialchars($single['image_path']) ?: 'assets/images/vinyl_placeholder.jpg'
            ]);
        }
    } else {
        echo '<p>Nessun singolo o EP disponibile.</p>';
    }
    
    mysqli_stmt_close($stmt);
    return ob_get_clean();
}
