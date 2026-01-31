<?php
include_once 'php/classes/DbConnection.php';

function album_credits($disk_id) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT DISTINCT a.author_name, a.image_path
         FROM author a
         JOIN disk_author_release dar ON a.id = dar.author_id
         WHERE dar.disk_id = ?"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '';
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) === 0) {
        return '';
    }
    
    $artist = mysqli_fetch_assoc($result);
    $image = !empty($artist['image_path'])
        ? $artist['image_path']
        : 'assets/images/pollo.webp';
    
    $artist_name = htmlspecialchars($artist['author_name']);
    $image_escaped = htmlspecialchars($image);
    
    ob_start();
    echo Template::render('static/layout/album/credit_item.html', [
        'credit_image' => $image_escaped,
        'credit_name' => $artist_name,
        'credit_role' => 'Co-writing'
    ]);
    echo Template::render('static/layout/album/credit_item.html', [
        'credit_image' => $image_escaped,
        'credit_name' => $artist_name,
        'credit_role' => 'Producer'
    ]);
    $credits_html = ob_get_clean();
    
    mysqli_stmt_close($stmt);
    
    return '<section class="album-credits" aria-labelledby="credits-heading">'
         . '<h2 id="credits-heading">Crediti</h2>'
         . '<div class="credits-grid">'
         . $credits_html
         . '</div></section>';
}
