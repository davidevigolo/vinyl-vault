<?php
include_once 'php/classes/DbConnection.php';

function album_tracklist($disk_id, $edition_name) {
    $connection = DbConnection::get_instance();
    
    $stmt = mysqli_prepare($connection->get_connection(),
        "SELECT t.id, t.title, t.duration_seconds, etp.track_number, e.country
         FROM track t
         JOIN edition_track_part_of etp ON t.id = etp.track_id
         JOIN edition e ON etp.disk_id = e.disk_id AND etp.edition_name = e.edition_name
         WHERE etp.disk_id = ? AND etp.edition_name = ?
         ORDER BY etp.track_number ASC"
    );
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return '<p class="empty-state">Errore nel caricamento della tracklist.</p>';
    }
    
    mysqli_stmt_bind_param($stmt, 'is', $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $track_count = mysqli_num_rows($result);
    $is_single = $track_count === 1;
    if ($track_count === 0 || $track_count < 1) {
        error_log("Tracklist not found or too short for disk_id: $disk_id, edition_name: $edition_name");
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
            'lang' => htmlspecialchars($row['country']),
            'track_duration' => $duration,
            'track_duration_datetime' => sprintf('%dm %02ds', $minutes, $seconds),
        ]);
    }
    $tracks_html = ob_get_clean();
    
    mysqli_stmt_close($stmt);
    
    if($is_single) {
        return '<section id="tracklist-section" class="tracklist-section" aria-labelledby="tracklist-heading">'
             . '<div class="center-container">'
             . '<h2 id="tracklist-heading">Singolo</h2>'
             . '<div class="tracklist-single"><ol aria-label="Lista delle tracce">'
             . $tracks_html
             . '</ol></div></div></section>';
    }
    return '<section id="tracklist-section" class="tracklist-section" aria-labelledby="tracklist-heading">'
         . '<div class="center-container">'
         . '<h2 id="tracklist-heading">Tracklist</h2>'
         . '<ol class="tracklist" aria-label="Lista delle tracce">'
         . $tracks_html
         . '</ol></div></section>';
}
