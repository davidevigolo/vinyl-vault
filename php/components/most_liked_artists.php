<?php
include_once 'php/classes/DbConnection.php';
function get_most_liked_artists()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT a.author_name, a.image_path FROM author a LIMIT 6";

    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
        }
    // here the connection should be closed.
    return $result;
}

function most_liked_artists()
{
    ob_start();
    $mostLikedArtists = get_most_liked_artists();
    if ($mostLikedArtists) {
        while ($artist = mysqli_fetch_assoc($mostLikedArtists)) {
            echo Template::render('static/layout/most_liked_artists_card.html', [
                'artist_name' => htmlspecialchars($artist['author_name']),
                'image_path' => htmlspecialchars($artist['image_path'])
            ]);
        }
    }
    return ob_get_clean();
}

?>