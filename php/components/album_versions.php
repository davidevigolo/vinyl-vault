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
    echo '<section class="album-versions card-section" aria-labelledby="versions-heading">';
    echo '<h2 id="versions-heading">Versioni</h2>';
    echo '<div class="versions-container">';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $image = !empty($row['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $row['image_path'])
            ? $row['image_path']
            : 'assets/images/pollo.webp';
        
        $release_year = date('Y', strtotime($row['release_date']));
        
        echo '<a href="album.php?id=' . $row['id'] . '" class="card-link-wrapper">';
        echo '<article class="vinyl-card">';
        echo '<div class="card-image">';
        echo '<img src="' . htmlspecialchars($image) . '" alt="Copertina di ' . htmlspecialchars($row['title']) . '">';
        echo '</div>';
        echo '<div class="card-content">';
        echo '<p class="artist-name">' . htmlspecialchars($row['author_name']) . '</p>';
        echo '<h3 class="album-title">' . htmlspecialchars($row['title']) . '</h3>';
        echo '<p class="edition-info">' . htmlspecialchars($row['edition_name']) . ' - ' . $release_year . ' - ' . htmlspecialchars($row['country']) . '</p>';
        echo '</div>';
        echo '</article>';
        echo '</a>';
    }
    
    echo '</div>';
    echo '</section>';
    return ob_get_clean();
}
