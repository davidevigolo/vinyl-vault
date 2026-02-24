<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'php/classes/DbConnection.php';

function album_versions($disk_id, $edition_name) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT DISTINCT d2.id, d2.title, e2.edition_name, e2.release_date, e2.image_path, e2.country,
            a.author_name
         FROM disk d1
         JOIN disk d2 ON d1.id = d2.id
         JOIN edition e2 ON d2.id = e2.disk_id
         JOIN edition e1 ON d1.id = e1.disk_id
         JOIN disk_author_release dar2 ON d2.id = dar2.disk_id
         JOIN author a ON dar2.author_id = a.id
         WHERE d1.id = ? AND d2.id = ? AND e1.edition_name != e2.edition_name AND e2.edition_name != ?
         ORDER BY e1.release_date DESC
         LIMIT 8"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '';
    }
    
    mysqli_stmt_bind_param($stmt, 'iis', $disk_id, $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) === 0) {
        return '';
    }
    
    ob_start();
    while ($row = mysqli_fetch_assoc($result)) {
        
        $release_year = date('Y', strtotime($row['release_date']));
        $edition_info = htmlspecialchars($row['edition_name']);
        
        echo Template::render('static/layout/vinyl_card.html', [
            'disk_id' => $row['id'],
            'ed_name' => $edition_info,
            'ed_name_url' => urlencode($row['edition_name']),
            'title' => htmlspecialchars($row['title']),
            'artist' => htmlspecialchars($row['author_name']),
            'nationality' => htmlspecialchars(get_nationality_languages()[strtolower($row['country'])]),
            'cover_image' => htmlspecialchars($row['image_path']) ?: 'assets/images/vinyl_placeholder.jpg'
        ]);
    }
    $cards_html = ob_get_clean();
    
    mysqli_stmt_close($stmt);
    
    return '<section id="versions-section" class="album-versions card-section" aria-labelledby="versions-heading">'
         . '<div class="center-container">'
         . '<h2 id="versions-heading">Versioni</h2>'
         . '<div class="cards-container">'
         . $cards_html
         . '</div></div></section>';
}
