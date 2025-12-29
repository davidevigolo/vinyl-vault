<?php
include 'php/classes/DbConnection.php';
function get_trending_vinyls()
{
    $connection = new DbConnection();
    $connection->openDBConnection();
    $query = "SELECT v.disk_id, v.edition_name, v.title, v.author_name, v.image_path, w.wl_count
                FROM vinyl as v JOIN wishlist_count as w on v.disk_id = w.disk_id AND v.edition_name = w.edition_name
                ORDER BY w.wl_count DESC
                LIMIT 10;";
    $result = mysqli_query($connection->getConnection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->getConnection()));
        return false;
        }
    $connection->closeConnection();
    return $result;
}

function trending_vinyls()
{
    ob_start();
    $trendingVinyls = get_trending_vinyls();
    if ($trendingVinyls) {
        while ($vinyl = mysqli_fetch_assoc($trendingVinyls)) {
            echo Template::render('static/layout/trending_vinyl_card.html', [
                'disk_id' => bin2hex($vinyl['disk_id']),
                'ed_name' => $vinyl['edition_name'],
                'title' => htmlspecialchars($vinyl['title']),
                'artist' => htmlspecialchars($vinyl['author_name']),
                'cover_image' => htmlspecialchars($vinyl['image_path']),
                'wishlist_count' => $vinyl['wl_count']
            ]);
        }
    }
    return ob_get_clean();
}

?>