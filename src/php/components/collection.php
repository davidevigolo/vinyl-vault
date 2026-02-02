<?php
include_once 'php/classes/DbConnection.php';
require_once 'php/classes/Template.php';
require_once 'php/classes/utils.php';

function get_collection() {
    $connection = DbConnection::get_instance();
    $query = "SELECT o.disk_id, e.image_path, d.title, a.author_name as author, a.id as author_id, e.edition_name, e.country, e.release_date, o.rating, a.nationality
       FROM ownership o 
       JOIN edition e ON o.disk_id = e.disk_id AND o.edition_name = e.edition_name
       JOIN disk d ON d.id = e.disk_id 
       JOIN disk_author_release dar ON d.id = dar.disk_id
       JOIN author a ON dar.author_id = a.id
       WHERE o.user_id = " . intval($_SESSION['user_id']) . "
       ORDER BY o.date_acquired DESC; ";
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function collection($edit_mode = false) {
    ob_start();
    $collection = get_collection();
    $items = '';
    if (!$collection || mysqli_num_rows($collection) === 0) {
        echo Template::render('static/layout/collection/empty_collection.html', []);
        return ob_get_clean();
    }
    if ($collection) {
        while ($vinyl = mysqli_fetch_assoc($collection)) {
            $items .= Template::render($edit_mode ? 'static/layout/collection/collection_item_edit.html' : 'static/layout/collection/collection_item.html', [
                'title' => htmlspecialchars($vinyl['title']),
                'author' => htmlspecialchars($vinyl['author']),
                'author_id' => htmlspecialchars($vinyl['author_id']),
                'edition_name' => htmlspecialchars($vinyl['edition_name']),
                'edition_name_url' => urlencode($vinyl['edition_name']),
                'edition_name_id' => htmlspecialchars(str_replace(' ', '-', $vinyl['edition_name'])),
                'nationality' => htmlspecialchars(get_nationality_languages()[strtolower($vinyl['country'])]),
                'country' => htmlspecialchars($vinyl['country']),
                'year' => htmlspecialchars(str_replace('-', '/', $vinyl['release_date'])),
                'year_datetime' => htmlspecialchars($vinyl['release_date']),
                'image_url' => htmlspecialchars($vinyl['image_path']) ?: 'assets/images/vinyl_placeholder.jpg',
                'disk_id' => htmlspecialchars($vinyl['disk_id']),
                'rating_value' => isset($_SESSION['manage_collection_result']['rating']) ? intval($_SESSION['manage_collection_result']['rating'][$vinyl['disk_id'] . '_' . $vinyl['edition_name']] ?? 0) : intval($vinyl['rating'] ?? 0),
                'checked' => (isset($_SESSION['manage_collection_result']['items_to_delete'][$vinyl['disk_id'] . '_' . $vinyl['edition_name']]) && $_SESSION['manage_collection_result']['items_to_delete'][$vinyl['disk_id'] . '_' . $vinyl['edition_name']]) ? 'checked' : ''
            ]);
        }
    }
    echo Template::render($edit_mode ? 'static/layout/collection/collection_grid_edit.html' : 'static/layout/collection/collection_grid.html', [
        'collection_items' => $items,
        'errors' => isset($_SESSION['manage_collection_result']['error']) ? $_SESSION['manage_collection_result']['error'] : ''
    ]);
    unset($_SESSION['manage_collection_result']);
    return ob_get_clean();
}

