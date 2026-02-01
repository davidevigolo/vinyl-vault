<?php
include_once 'php/classes/DbConnection.php';
require_once 'php/classes/utils.php';
function get_most_liked_artists()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT a.id, a.author_name, a.image_path, a.nationality, COUNT(DISTINCT o.user_id) as collector_count
              FROM author as a
              JOIN disk_author_release as dar ON dar.author_id = a.id
              JOIN ownership as o ON o.disk_id = dar.disk_id
              GROUP BY a.id, a.author_name, a.image_path, a.nationality
              ORDER BY collector_count DESC
              LIMIT 4;";

    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function most_liked_artists()
{
    ob_start();
    $mostLikedArtists = get_most_liked_artists();
    if ($mostLikedArtists && mysqli_num_rows($mostLikedArtists) > 0) {
        while ($artist = mysqli_fetch_assoc($mostLikedArtists)) {
            $artist_image = htmlspecialchars($artist['image_path']) ?: 'assets/images/artist_placeholder.jpg';
            
            echo Template::render('static/layout/most_liked_artists_card.html', [
                'artist_id' => $artist['id'],
                'artist_name' => htmlspecialchars($artist['author_name']),
                'nationality' => htmlspecialchars(get_nationality_languages()[$artist['nationality']] ?? 'en'),
                'image_path' => $artist_image
            ]);
        }
    } else {
        echo '<p>Nessun artista disponibile al momento.</p>';
    }
    return ob_get_clean();
}