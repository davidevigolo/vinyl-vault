<?php
include_once 'php/classes/DbConnection.php';

function get_wishlist(){
    $connection = DbConnection::get_instance();
    $query = "SELECT e.image_path, d.title, e.edition_name, e.country, e.release_date, w.priority_level
       FROM wishlist w join edition e on w.disk_id = e.disk_id and w.edition_name = e.edition_name
       JOIN disk d on d.id= e.disk_id";
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function wishlist()
{
    ob_start();
    $wishlist = get_wishlist();
    $rows = '';
    if ($wishlist) {
        while ($vinyl = mysqli_fetch_assoc($wishlist)) {
            // TBD: Usare image_path quando le immagini saranno caricate
            $rows .= Template::render('static/layout/wishlist/wishlist_table_row.html', [
                'title' => htmlspecialchars($vinyl['title']),
                'target_edition' => htmlspecialchars($vinyl['edition_name']),
                'country' => htmlspecialchars($vinyl['country']),
                'year' => htmlspecialchars($vinyl['release_date']),
                'priority_level' => htmlspecialchars($vinyl['priority_level']),
                'image_url' => 'assets/images/pollo.webp',
            ]);
        }
    }
    echo Template::render('static/layout/wishlist/wishlist_table.html', [
        'wishlist_table_rows' => $rows
    ]);
    return ob_get_clean();
}

