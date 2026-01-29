<?php
include_once 'php/classes/DbConnection.php';

function get_top_artists() {
    $connection = DbConnection::get_instance();
    $query = "SELECT a.author_name, a.nationality, a.image_path, COUNT(o.user_id) AS total_ownership_count
                FROM author a
                JOIN disk_author_release dar ON a.id = dar.author_id
                JOIN disk d ON dar.disk_id = d.id
                JOIN edition e ON d.id = e.disk_id
                LEFT JOIN ownership o ON e.disk_id = o.disk_id AND e.edition_name = o.edition_name
                GROUP BY a.id, a.author_name, a.nationality, a.image_path
                ORDER BY total_ownership_count DESC
                LIMIT 6";

    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function top_artists() {
    $ordinali = [
        1 => "Primo",
        2 => "Secondo",
        3 => "Terzo",
        4 => "Quarto",
        5 => "Quinto",
        6 => "Sesto"
    ];
    ob_start();
    $topArtists = get_top_artists();
    $i = 1;
    if ($topArtists) {
        while ($vinyl = mysqli_fetch_assoc($topArtists)) {
            $span = $i === 1 ? 'span-6' : 'span-3';
            $span = $i > 3 ? 'span-2' : $span;
            // TBD: Usare image_path quando le immagini saranno caricate
            echo Template::render('static/layout/top_artists/top_artists_card.html', [
                'artist' => htmlspecialchars($vinyl['author_name']),
                'cover_image' => htmlspecialchars($vinyl['image_path']) ? htmlspecialchars($vinyl['image_path']) : 'assets/images/artist_placeholder.jpg',
                'span_class' => $span,
                'direction' => $i > 3 ? 'direction-vertical' : 'direction-horizontal',
                'index' => $i,
                'ordinal_index' => $ordinali[$i],
            ]);
            $i++;
        }
    }
    return ob_get_clean();
}