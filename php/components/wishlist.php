<?php
include_once 'php/classes/DbConnection.php';

function get_wishlist(){
    $connection = DbConnection::get_instance();
    $query = "SELECT w.disk_id,e.image_path, d.title, e.edition_name, e.country, e.release_date, w.priority_level
       FROM wishlist w join edition e on w.disk_id = e.disk_id and w.edition_name = e.edition_name
       JOIN disk d on d.id= e.disk_id ORDER BY w.priority_level DESC;";
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
    $rows = '';
    if ($wishlist) {
        while ($vinyl = mysqli_fetch_assoc($wishlist)) {
            // TBD: Usare image_path quando le immagini saranno caricate
            $rows .= Template::render($edit_mode ? 'static/layout/wishlist/wishlist_table_row_edit.html' : 'static/layout/wishlist/wishlist_table_row.html', [
                'title' => htmlspecialchars($vinyl['title']),
                'target_edition' => htmlspecialchars($vinyl['edition_name']),
                'country' => htmlspecialchars($vinyl['country']),
                'year' => htmlspecialchars(str_replace('-', '/', $vinyl['release_date'])),
                'year_datetime' => htmlspecialchars($vinyl['release_date']),
                'priority_level' => htmlspecialchars($vinyl['priority_level']),
                'image_url' => 'assets/images/pollo.webp',
                'remove_button' => $edit_mode ? '<form action="php/controllers/delete_wishlist_item.php" method="POST">
                                                <input type="hidden" name="disk_id" value="' . $vinyl['disk_id'] . '">
                                                <input type="hidden" name="edition_name" value="' . htmlspecialchars($vinyl['edition_name']) . '">
                                                <input type="submit" aria-label="Rimuovi ' . htmlspecialchars($vinyl['title']) . ' dalla lista dei desideri" value="Rimuovi" class="remove-button"></form>' : ''
            ]);
        }
    }
    echo Template::render($edit_mode ? 'static/layout/wishlist/wishlist_table_edit.html' : 'static/layout/wishlist/wishlist_table.html', [
        'wishlist_table_rows' => $rows
    ]);
    return ob_get_clean();
}

