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
        return '<p class="empty-state">Errore nel caricamento della tracklist.</p>';
    }
    
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $track_count = mysqli_num_rows($result);
    if ($track_count === 0 || $track_count <= 2) {
        return '';
    }
    
    ob_start();
    while ($row = mysqli_fetch_assoc($result)) {
        $minutes = floor($row['duration_seconds'] / 60);
        $seconds = $row['duration_seconds'] % 60;
        $duration = sprintf('%d:%02d', $minutes, $seconds);
        
        echo Template::render('static/layout/album/track_item.html', [
            'track_number' => $row['track_number'],
            'track_title' => htmlspecialchars($row['title']),
            'track_duration' => $duration
        ]);
    }
    $tracks_html = ob_get_clean();
    
    mysqli_stmt_close($stmt);
    
    return '<section id="tracklist-section" class="tracklist-section" aria-labelledby="tracklist-heading">'
         . '<div class="center-container">'
         . '<h2 id="tracklist-heading">Tracklist</h2>'
         . '<ol class="tracklist" aria-label="Tracklist dell\'album">'
         . $tracks_html
         . '</ol></div></section>';
}
