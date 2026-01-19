<?php
include_once 'php/classes/DbConnection.php';

function album_tracklist($disk_id) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT t.id, t.title, t.duration_seconds, etp.track_number
         FROM track t
         JOIN edition_track_part_of etp ON t.id = etp.track_id
         WHERE etp.disk_id = ?
         ORDER BY etp.track_number ASC"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '<p class="empty-state">Errore nel caricamento della tracklist</p>';
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $track_count = mysqli_num_rows($result);
    
    // Per i singoli (1-2 tracce), non mostrare la tracklist
    if ($track_count === 0 || $track_count <= 2) {
        return '';
    }
    
    ob_start();
    echo '<section id="tracklist-section" class="tracklist-section" aria-labelledby="tracklist-heading">';
    echo '<div class="center-container">';
    echo '<h2 id="tracklist-heading">Tracklist</h2>';
    echo '<ol class="tracklist" aria-label="Tracklist dell\'album">';
    
    while ($row = mysqli_fetch_assoc($result)) {
        $minutes = floor($row['duration_seconds'] / 60);
        $seconds = $row['duration_seconds'] % 60;
        $duration = sprintf('%d:%02d', $minutes, $seconds);
        
        echo '<li class="track-item">';
        echo '<span class="track-number" aria-label="Traccia numero ' . $row['track_number'] . '">' . $row['track_number'] . '</span>';
        echo '<span class="track-title">' . htmlspecialchars($row['title']) . '</span>';
        echo '<span class="track-duration">' . $duration . '</span>';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</div>';
    echo '</section>';
    return ob_get_clean();
}
