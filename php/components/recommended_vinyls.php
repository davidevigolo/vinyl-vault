<?php
include_once 'php/classes/DbConnection.php';
require_once 'php/classes/utils.php';

function get_recommended_vinyls()
{
    $connection = DbConnection::get_instance();
    
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        $genre_query = "SELECT dgc.genre_name, COUNT(*) as genre_count
                        FROM ownership as o
                        JOIN disk_genre_classification as dgc ON o.disk_id = dgc.disk_id
                        WHERE o.user_id = ?
                        GROUP BY dgc.genre_name
                        ORDER BY genre_count DESC
                        LIMIT 1;";
        
        $stmt = mysqli_prepare($connection->get_connection(), $genre_query);
        mysqli_stmt_bind_param($stmt, "s", $user_id);
        mysqli_stmt_execute($stmt);
        $genre_result = mysqli_stmt_get_result($stmt);
        $favorite_genre = mysqli_fetch_assoc($genre_result);
        
        if ($favorite_genre) {
            $recommendations_query = "SELECT DISTINCT ed.disk_id, ed.edition_name, d.title, 
                                             au.author_name, au.id as author_id, ed.image_path, au.nationality
                                      FROM edition as ed
                                      JOIN disk as d ON ed.disk_id = d.id
                                      JOIN disk_author_release as dar ON dar.disk_id = ed.disk_id
                                      JOIN author as au ON au.id = dar.author_id
                                      JOIN disk_genre_classification as dgc ON dgc.disk_id = ed.disk_id
                                      WHERE dgc.genre_name = ?
                                      AND NOT EXISTS (
                                          SELECT 1 FROM ownership as o 
                                          WHERE o.disk_id = ed.disk_id 
                                          AND o.edition_name = ed.edition_name 
                                          AND o.user_id = ?
                                      )
                                      ORDER BY RAND()
                                      LIMIT 4;";
            
            $stmt = mysqli_prepare($connection->get_connection(), $recommendations_query);
            mysqli_stmt_bind_param($stmt, "ss", $favorite_genre['genre_name'], $user_id);
            mysqli_stmt_execute($stmt);
            return mysqli_stmt_get_result($stmt);
        }
    }
    
    $fallback_query = "SELECT ed.disk_id, ed.edition_name, d.title, au.author_name, 
                              au.id as author_id, ed.image_path, au.nationality, COUNT(o.user_id) as ownership_count
                       FROM ownership as o
                       JOIN edition as ed ON o.disk_id = ed.disk_id AND o.edition_name = ed.edition_name
                       JOIN disk as d ON d.id = ed.disk_id
                       JOIN disk_author_release as dar ON dar.disk_id = ed.disk_id
                       JOIN author as au ON au.id = dar.author_id
                       GROUP BY ed.disk_id, ed.edition_name, d.title, au.author_name, au.id, ed.image_path
                       ORDER BY ownership_count DESC
                       LIMIT 4;";
    
    $result = mysqli_query($connection->get_connection(), $fallback_query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function recommended_vinyls()
{
    ob_start();
    $recommendations = get_recommended_vinyls();
    
    if ($recommendations && mysqli_num_rows($recommendations) > 0) {
        while ($vinyl = mysqli_fetch_assoc($recommendations)) {
            // TBD: Implementare gestione immagini reali
            $cover_image = htmlspecialchars($vinyl['image_path']);
            
            echo Template::render('static/layout/vinyl_card.html', [
                'disk_id' => $vinyl['disk_id'],
                'ed_name' => htmlspecialchars($vinyl['edition_name']),
                'ed_name_url' => urlencode($vinyl['edition_name']),
                'nationality' => htmlspecialchars(get_nationality_languages()[$vinyl['nationality']] ?? 'en'),
                'title' => htmlspecialchars($vinyl['title']),
                'artist' => htmlspecialchars($vinyl['author_name']),
                'artist_id' => $vinyl['author_id'],
                'cover_image' => htmlspecialchars($vinyl['image_path']) ?: 'assets/images/pollo.webp'
            ]);
        }
    } else {
        echo '<p>Nessuna raccomandazione disponibile al momento.</p>';
    }
    
    return ob_get_clean();
}
