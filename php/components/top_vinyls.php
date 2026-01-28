<?php
include_once 'php/classes/DbConnection.php';

function get_top_vinyls()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT a.author_name, d.title, e.edition_name, e.image_path, COUNT(o.user_id) AS ownership_count
                FROM disk d
                JOIN edition e ON d.id = e.disk_id
                JOIN disk_author_release dar ON d.id = dar.disk_id
                JOIN author a ON dar.author_id = a.id
                LEFT JOIN ownership o ON e.disk_id = o.disk_id AND e.edition_name = o.edition_name
                GROUP BY d.id, e.edition_name, a.author_name
                ORDER BY ownership_count DESC
                LIMIT 20";

    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    return $result;
}

function top_vinyls()
{
    $ordinali = [
    1 => "Primo",
    2 => "Secondo",
    3 => "Terzo",
    4 => "Quarto",
    5 => "Quinto",
    6 => "Sesto",
    7 => "Settimo",
    8 => "Ottavo",
    9 => "Nono",
    10 => "Decimo",
    11 => "Undicesimo",
    12 => "Dodicesimo",
    13 => "Tredicesimo",
    14 => "Quattordicesimo",
    15 => "Quindicesimo",
    16 => "Sedicesimo",
    17 => "Diciassettesimo",
    18 => "Diciottesimo",
    19 => "Diciannovesimo",
    20 => "Ventesimo"
    ];
    ob_start();
    $topVinyls = get_top_vinyls();
    $i = 1;
    if ($topVinyls) {
        while ($vinyl = mysqli_fetch_assoc($topVinyls)) {
            $span = $i === 1 ? 'span-6' : 'span-3';
            $span = $i > 3 ? 'span-2' : $span;
            // TBD: Usare image_path quando le immagini saranno caricate
            echo Template::render('static/layout/top_vinyls/top_vinyl_card.html', [
                'artist' => htmlspecialchars($vinyl['author_name']),
                'title' => htmlspecialchars($vinyl['title']),
                'ed_name' => htmlspecialchars($vinyl['edition_name']),
                'cover_image' => htmlspecialchars($vinyl['image_path']) ?:  ?: 'assets/images/vinyl_placeholder.jpg',
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