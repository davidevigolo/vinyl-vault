<?php
include_once 'php/classes/DbConnection.php';

function get_wishlist(){
    $connection = DbConnection::get_instance();
    $query = "SELECT w.disk_id, e.image_path, d.title, a.author_name as author, e.edition_name, e.country, e.release_date, w.priority_level
       FROM wishlist w 
       JOIN edition e ON w.disk_id = e.disk_id AND w.edition_name = e.edition_name
       JOIN disk d ON d.id = e.disk_id 
       JOIN disk_author_release dar ON d.id = dar.disk_id
       JOIN author a ON dar.author_id = a.id
       WHERE w.user_id = " . intval($_SESSION['user_id']) . "
       ORDER BY w.priority_level DESC; ";
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function wishlist($edit_mode = false)
{
    ob_start();
    $wishlist = get_wishlist();
    $items = '';
    if(!$wishlist || mysqli_num_rows($wishlist) === 0){
        echo Template::render('static/layout/wishlist/empty_wishlist.html', []);
        return ob_get_clean();
    }
    if ($wishlist) {
        while ($vinyl = mysqli_fetch_assoc($wishlist)) {
            // TBD: Usare image_path quando le immagini saranno caricate
            $items .= Template::render($edit_mode ? 'static/layout/wishlist/wishlist_item_edit.html' : 'static/layout/wishlist/wishlist_item.html', [
                'title' => htmlspecialchars($vinyl['title']),
                'author' => htmlspecialchars($vinyl['author']),
                'edition_name' => htmlspecialchars($vinyl['edition_name']),
                'country' => htmlspecialchars($vinyl['country']),
                'year' => htmlspecialchars(str_replace('-', '/', $vinyl['release_date'])),
                'year_datetime' => htmlspecialchars($vinyl['release_date']),
                'priority_level' => htmlspecialchars($vinyl['priority_level']),
                'image_url' => 'assets/images/pollo.webp',
                'disk_id' => htmlspecialchars($vinyl['disk_id'])
            ]);
        }
    }
    echo Template::render($edit_mode ? 'static/layout/wishlist/wishlist_grid_edit.html' : 'static/layout/wishlist/wishlist_grid.html', [
        'wishlist_items' => $items
    ]);
    return ob_get_clean();
}

