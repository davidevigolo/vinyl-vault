<?php
include_once 'php/classes/DbConnection.php';

function album_credits($disk_id) {
    $connection = DbConnection::get_instance();
    
    // Per ora ritorniamo crediti mock basati sull'artista dell'album
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT DISTINCT a.author_name, a.image_path
         FROM author a
         JOIN disk_author_release dar ON a.id = dar.author_id
         WHERE dar.disk_id = ?"
    );
    
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) === 0) {
        return '';
    }
    
    $artist = mysqli_fetch_assoc($result);
    $image = !empty($artist['image_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $artist['image_path'])
        ? $artist['image_path']
        : 'assets/images/pollo.webp';
    
    ob_start();
    echo '<section class="album-credits" aria-labelledby="credits-heading">';
    echo '<h2 id="credits-heading">Crediti</h2>';
    echo '<div class="credits-grid">';
    
    // Co-writing credit
    echo '<div class="credit-item">';
    echo '<img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($artist['author_name']) . '" class="credit-avatar">';
    echo '<div class="credit-info">';
    echo '<p class="credit-name">' . htmlspecialchars($artist['author_name']) . '</p>';
    echo '<p class="credit-role">Co-writing</p>';
    echo '</div>';
    echo '</div>';
    
    // Producer credit
    echo '<div class="credit-item">';
    echo '<img src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($artist['author_name']) . '" class="credit-avatar">';
    echo '<div class="credit-info">';
    echo '<p class="credit-name">' . htmlspecialchars($artist['author_name']) . '</p>';
    echo '<p class="credit-role">Producer</p>';
    echo '</div>';
    echo '</div>';
    
    echo '</div>';
    echo '</section>';
    return ob_get_clean();
}
