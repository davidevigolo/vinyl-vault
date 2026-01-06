<?php
include_once 'php/classes/DbConnection.php';

function get_most_collected_vinyls()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT ed.disk_id, ed.edition_name, d.title, ed.image_path, COUNT(o.user_id) as ownership_count,
                (SELECT a.id FROM disk_author_release dar 
                 JOIN author a ON dar.author_id = a.id 
                 WHERE dar.disk_id = ed.disk_id 
                 LIMIT 1) as author_id,
                (SELECT a.author_name FROM disk_author_release dar 
                 JOIN author a ON dar.author_id = a.id 
                 WHERE dar.disk_id = ed.disk_id 
                 LIMIT 1) as author_name
              FROM ownership as o
              JOIN edition as ed ON o.disk_id = ed.disk_id AND o.edition_name = ed.edition_name
              JOIN disk as d ON d.id = ed.disk_id
              GROUP BY ed.disk_id, ed.edition_name, d.title, ed.image_path
              ORDER BY ownership_count DESC
              LIMIT 4;";
    
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function most_collected_vinyls()
{
    ob_start();
    $mostCollected = get_most_collected_vinyls();
    
    if ($mostCollected && mysqli_num_rows($mostCollected) > 0) {
        while ($vinyl = mysqli_fetch_assoc($mostCollected)) {
            // TBD: Usare image_path quando le immagini saranno caricate
            echo Template::render('static/layout/trending_vinyl_card.html', [
                'disk_id' => bin2hex($vinyl['disk_id']),
                'ed_name' => htmlspecialchars($vinyl['edition_name']),
                'title' => htmlspecialchars($vinyl['title']),
                'artist_id' => bin2hex($vinyl['author_id']),
                'artist' => htmlspecialchars($vinyl['author_name']),
                'cover_image' => 'assets/images/pollo.webp'
            ]);
        }
    } else {
        echo '<p>Nessun vinile disponibile al momento, ma presto si! :)</p>';
    }
    
    return ob_get_clean();
}
