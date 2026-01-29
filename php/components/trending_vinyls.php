<?php
include_once 'php/classes/DbConnection.php';
function get_trending_vinyls() {
    $connection = DbConnection::get_instance();
    $query = "SELECT w.disk_id, w.edition_name, d.title, ed.image_path, w.wl_count,
                (SELECT a.id FROM disk_author_release dar 
                 JOIN author a ON dar.author_id = a.id 
                 WHERE dar.disk_id = w.disk_id 
                 LIMIT 1) as author_id,
                (SELECT a.author_name FROM disk_author_release dar 
                 JOIN author a ON dar.author_id = a.id 
                 WHERE dar.disk_id = w.disk_id 
                 LIMIT 1) as author_name
                FROM wishlist_count as w
                JOIN disk d ON w.disk_id = d.id
                JOIN edition ed ON w.disk_id = ed.disk_id AND w.edition_name = ed.edition_name
                ORDER BY w.wl_count DESC
                LIMIT 4;";
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function trending_vinyls() {
    ob_start();
    $trendingVinyls = get_trending_vinyls();
    if ($trendingVinyls) {
        while ($vinyl = mysqli_fetch_assoc($trendingVinyls)) {
            // TBD: Usare image_path quando le immagini saranno caricate
            echo Template::render('static/layout/vinyl_card.html', [
                'disk_id' => $vinyl['disk_id'],
                'ed_name' => $vinyl['edition_name'],
                'title' => htmlspecialchars($vinyl['title']),
                'artist_id' => $vinyl['author_id'],
                'artist' => htmlspecialchars($vinyl['author_name']),
                'cover_image' => htmlspecialchars($vinyl['image_path']) ? htmlspecialchars($vinyl['image_path']) : 'assets/images/vinyl_placeholder.jpg',
                'wishlist_count' => $vinyl['wl_count']
            ]);
        }
    }
    return ob_get_clean();
}