<?php
include_once 'php/classes/DbConnection.php';

function get_album_info($disk_id, $edition_name) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(), 
        "SELECT d.id, d.title, d.disk_type, a.id as artist_id, e.edition_name as edition_name, e.release_date as release_date, d.label as label, e.country as country, a.author_name as artist_name, 
                YEAR(e.release_date) as release_year, e.image_path,
                COALESCE(AVG(o.rating), 0) as avg_rating,
                COUNT(DISTINCT r.user_id) as review_count
         FROM disk d
         JOIN disk_author_release dar ON d.id = dar.disk_id
         JOIN author a ON dar.author_id = a.id
         LEFT JOIN edition e ON d.id = e.disk_id
         LEFT JOIN review r ON d.id = r.disk_id AND r.edition_name = e.edition_name
         LEFT JOIN ownership o ON d.id = o.disk_id AND o.edition_name = e.edition_name
         WHERE d.id = ? AND e.edition_name = ?
         GROUP BY d.id, d.title, d.disk_type, a.id, e.edition_name, a.author_name, e.release_date, e.country, d.label, e.image_path
         LIMIT 1"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return null;
    }
    
    mysqli_stmt_bind_param($stmt, 'is', $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $ownership_count = get_ownership_count($disk_id, $edition_name);
        $wishlist_count = get_wishlist_count($disk_id, $edition_name);
        $row['ownership_count'] = $ownership_count;
        $row['wishlist_count'] = $wishlist_count;
        return $row;
    }
    
    return null;
}

function get_ownership_count($disk_id, $edition_name){
    $connection = DbConnection::get_instance();
    $query = "SELECT COUNT(*) as ownership_count FROM ownership WHERE disk_id = ? AND edition_name = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return 0;
    }
    mysqli_stmt_bind_param($stmt, 'is', $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['ownership_count'];
    }
    return 0;
}

function get_wishlist_count($disk_id, $edition_name){
    $connection = DbConnection::get_instance();
    $query = "SELECT COUNT(*) as wishlist_count FROM wishlist WHERE disk_id = ? AND edition_name = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return 0;
    }
    mysqli_stmt_bind_param($stmt, 'is', $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['wishlist_count'];
    }
    return 0;
}

function get_album_genres($disk_id) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT DISTINCT g.genre_name
         FROM disk_genre_classification dgc
         JOIN genre g ON dgc.genre_name = g.genre_name
         WHERE dgc.disk_id = ?
         ORDER BY g.genre_name"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '';
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $genres = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $genres[] = '<span class="tag">' . htmlspecialchars($row['genre_name']) . '</span>';
    }
    
    return implode(' ', $genres);
}
