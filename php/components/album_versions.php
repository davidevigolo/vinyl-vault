<?php
include_once 'php/classes/DbConnection.php';

function album_versions($disk_id) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT DISTINCT d2.id, d2.title, e.edition_name, e.release_date, e.image_path, e.country,
                a.author_name
         FROM disk d1
         JOIN disk_author_release dar1 ON d1.id = dar1.disk_id
         JOIN disk_author_release dar2 ON dar1.author_id = dar2.author_id
         JOIN disk d2 ON dar2.disk_id = d2.id
         JOIN edition e ON d2.id = e.disk_id
         JOIN author a ON dar2.author_id = a.id
         WHERE d1.id = ? AND d2.id != ?
         ORDER BY e.release_date DESC
         LIMIT 8"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '';
    }
    
    mysqli_stmt_bind_param($stmt, 'ii', $disk_id, $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) === 0) {
        return '';
    }
    
    ob_start();
    while ($row = mysqli_fetch_assoc($result)) {
        $image = !empty($row['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $row['image_path'])
            ? $row['image_path']
            : 'assets/images/pollo.webp';
        
        $release_year = date('Y', strtotime($row['release_date']));
        $edition_info = htmlspecialchars($row['edition_name']);
        
        echo Template::render('static/layout/vinyl_card.html', [
            'disk_id' => $row['id'],
            'ed_name' => $edition_info,
            'title' => htmlspecialchars($row['title']),
            'artist' => htmlspecialchars($row['author_name']),
            'cover_image' => htmlspecialchars($image)
        ]);
    }
    $cards_html = ob_get_clean();
    
    mysqli_stmt_close($stmt);
    
    return '<section class="album-versions card-section" aria-labelledby="versions-heading">'
         . '<div class="center-container">'
         . '<h2 id="versions-heading">Versioni</h2>'
         . '<div class="cards-container">'
         . $cards_html
         . '</div></div></section>';
}
