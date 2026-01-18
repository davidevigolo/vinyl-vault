<?php
include_once 'php/classes/DbConnection.php';

function get_artist_info($artist_id)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT id, author_name, nationality, image_path
              FROM author
              WHERE id = ?";
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'i', $artist_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result) {
        return false;
    }
    
    $artist = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    return $artist;
}

function get_artist_genres($artist_id)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT DISTINCT g.genre_name
              FROM genre g
              JOIN disk_genre_classification dgc ON g.genre_name = dgc.genre_name
              JOIN disk_author_release dar ON dgc.disk_id = dar.disk_id
              WHERE dar.author_id = ?
              LIMIT 5";
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return '';
    }
    mysqli_stmt_bind_param($stmt, 'i', $artist_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (!$result || mysqli_num_rows($result) === 0) {
        return '';
    }
    
    ob_start();
    while ($genre = mysqli_fetch_assoc($result)) {
        echo '<span class="tag" role="listitem">' . htmlspecialchars($genre['genre_name']) . '</span>';
    }
    mysqli_stmt_close($stmt);
    
    return ob_get_clean();
}
