<?php
include_once 'php/classes/DbConnection.php';

function get_catalog_vinyls($genres = null, $year_min = null, $year_max = null, $sort_by = 'collected', $limit = 6, $search = null) {
    $connection = DbConnection::get_instance();

    $query = "SELECT ed.disk_id, ed.edition_name, d.title, ed.image_path,
                (SELECT a.id FROM disk_author_release dar
                 JOIN author a ON dar.author_id = a.id
                 WHERE dar.disk_id = ed.disk_id
                 LIMIT 1) as author_id,
                (SELECT a.author_name FROM disk_author_release dar
                 JOIN author a ON dar.author_id = a.id
                 WHERE dar.disk_id = ed.disk_id
                 LIMIT 1) as author_name,
                YEAR(ed.release_date) as year,
                (SELECT COUNT(*) FROM ownership o
                 WHERE o.disk_id = ed.disk_id AND o.edition_name = ed.edition_name) as collection_count, a.nationality
              FROM edition ed
              JOIN disk_author_release dar ON ed.disk_id = dar.disk_id
              JOIN author a ON dar.author_id = a.id
              JOIN disk d ON ed.disk_id = d.id";

    $conditions = [];
    $params = [];
    $types = '';

    // Join per la ricerca testuale (necessario per cercare nell'autore)
    $need_author_join = ($search !== null && trim($search) !== '');
    if ($need_author_join) {
        $query .= " LEFT JOIN disk_author_release dar_search ON d.id = dar_search.disk_id";
        $query .= " LEFT JOIN author a_search ON dar_search.author_id = a_search.id";
    }

    if ($genres && is_array($genres) && count($genres) > 0) {
        $query .= " JOIN disk_genre_classification dgc ON d.id = dgc.disk_id";
        $placeholders = implode(',', array_fill(0, count($genres), '?'));
        $conditions[] = "dgc.genre_name IN ($placeholders)";
        foreach ($genres as $genre) {
            $params[] = $genre;
            $types .= 's';
        }
    }

    // Ricerca testuale su titolo, artista e edizione
    if ($search !== null && trim($search) !== '') {
        $search_term = '%' . trim($search) . '%';
        $conditions[] = "(d.title LIKE ? OR a_search.author_name LIKE ? OR ed.edition_name LIKE ?)";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= 'sss';
    }

    if ($year_min) {
        $conditions[] = "YEAR(ed.release_date) >= ?";
        $params[] = $year_min;
        $types .= 'i';
    }

    if ($year_max) {
        $conditions[] = "YEAR(ed.release_date) <= ?";
        $params[] = $year_max;
        $types .= 'i';
    }

    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    // Group by per evitare duplicati quando si fa JOIN con autori
    if ($need_author_join) {
        $query .= " GROUP BY ed.disk_id, ed.edition_name";
    }
    
    switch ($sort_by) {
        case 'recent':
            $query .= " ORDER BY ed.release_date DESC";
            break;
        case 'az':
            $query .= " ORDER BY d.title ASC";
            break;
        case 'collected':
        default:
            $query .= " ORDER BY collection_count DESC, ed.release_date DESC";
            break;
    }
    
    $query .= " LIMIT ?";
    $params[] = $limit;
    $types .= 'i';
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    
    if (!$stmt) {
        error_log("Query failed: " . mysqli_error($connection->get_connection()));
        return [];
    }
    
    if (count($params) > 0) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $vinyls = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $vinyls[] = $row;
    }
    
    mysqli_stmt_close($stmt);
    return $vinyls;
}

function get_all_genres() {
    $connection = DbConnection::get_instance();
    $query = "SELECT DISTINCT genre_name FROM genre ORDER BY genre_name ASC";
    $result = mysqli_query($connection->get_connection(), $query);
    
    $genres = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $genres[] = $row['genre_name'];
    }
    return $genres;
}

function get_total_catalog_count($genre = null, $year_min = null, $year_max = null) {
    $connection = DbConnection::get_instance();
    
    $query = "SELECT COUNT(*) as total
              FROM edition ed
              JOIN disk d ON ed.disk_id = d.id";
    
    $conditions = [];
    $params = [];
    $types = '';
    
    if ($genre) {
        $query .= " JOIN disk_genre_classification dgc ON d.id = dgc.disk_id";
        $conditions[] = "dgc.genre_name = ?";
        $params[] = $genre;
        $types .= 's';
    }
    
    if ($year_min) {
        $conditions[] = "YEAR(ed.release_date) >= ?";
        $params[] = $year_min;
        $types .= 'i';
    }
    
    if ($year_max) {
        $conditions[] = "YEAR(ed.release_date) <= ?";
        $params[] = $year_max;
        $types .= 'i';
    }
    
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }
    
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    
    if (!$stmt) {
        error_log("Count query failed: " . mysqli_error($connection->get_connection()));
        return 0;
    }
    
    if (count($params) > 0) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    mysqli_stmt_close($stmt);
    return $row['total'] ?? 0;
}

function get_year_range() {
    $connection = DbConnection::get_instance();
    $query = "SELECT MIN(YEAR(release_date)) as min_year, MAX(YEAR(release_date)) as max_year FROM edition";
    $result = mysqli_query($connection->get_connection(), $query);
    $row = mysqli_fetch_assoc($result);

    $current_year = intval(date('Y'));
    $db_max = $row['max_year'] ? intval($row['max_year']) : $current_year;

    return [
        'min' => $row['min_year'] ?: 1950,
        'max' => max($db_max, $current_year)
    ];
}

function render_catalog_cards($vinyls, $search_query = null) {
    if (empty($vinyls)) {
        $message = $search_query
            ? 'Nessun vinile trovato per "' . htmlspecialchars($search_query) . '". Prova con altri termini di ricerca.'
            : 'Nessun vinile trovato con questi filtri.';
        return '<p class="empty-state" role="status">' . $message . '</p>';
    }
    
    $initial_visible = 6;
    ob_start();
    foreach ($vinyls as $index => $vinyl) {
        $hidden_class = $index >= $initial_visible ? ' catalog-item-hidden' : '';
        echo '<div class="catalog-item' . $hidden_class . '">';
        echo Template::render('static/layout/vinyl_card.html', [
            'disk_id' => $vinyl['disk_id'],
            'ed_name' => htmlspecialchars($vinyl['edition_name']),
            'ed_name_url' => urlencode($vinyl['edition_name']),
            'nationality' => htmlspecialchars(get_nationality_languages()[$vinyl['nationality']]),
            'title' => htmlspecialchars($vinyl['title']),
            'artist_id' => $vinyl['author_id'],
            'artist' => htmlspecialchars($vinyl['author_name']),
            'cover_image' => htmlspecialchars($vinyl['image_path']) ?: 'assets/images/vinyl_placeholder.jpg'
        ]);
        echo '</div>';
    }
    return ob_get_clean();
}

function render_genres_checkboxes($genres, $prefix = '') {
    $current_genres = isset($_GET['genre']) ? (is_array($_GET['genre']) ? $_GET['genre'] : [$_GET['genre']]) : [];

    ob_start();
    foreach ($genres as $genre) {
        $checked = in_array($genre, $current_genres) ? 'checked' : '';
        $genre_escaped = htmlspecialchars($genre);
        // Crea un ID valido: solo lettere, numeri, trattini
        $id_safe = preg_replace('/[^a-z0-9-]/', '-', strtolower($genre));
        $id = $prefix . 'genre-' . $id_safe;
        echo '<div class="filter-option">';
        echo '<input type="checkbox" id="' . $id . '" name="genre[]" value="' . $genre_escaped . '" ' . $checked . '>';
        echo '<label for="' . $id . '">' . $genre_escaped . '</label>';
        echo '</div>';
    }
    return ob_get_clean();
}

function render_active_filters($filters) {
    if (empty($filters)) {
        return '';
    }

    ob_start();
    foreach ($filters as $filter) {
        if ($filter['type'] === 'year') {
            // Year filter is not removable - show without X button
            echo '<span class="filter-tag filter-tag-static">';
            echo htmlspecialchars($filter['label']);
            echo '</span>';
        } elseif ($filter['type'] === 'search') {
            // Search filter - removable
            $remove_url = build_remove_filter_url('search', $filter['value']);
            echo '<button type="button" class="filter-tag filter-tag-search remove-filter-btn" data-href="' . $remove_url . '" aria-label="Rimuovi ricerca ' . htmlspecialchars($filter['value']) . '">';
            echo htmlspecialchars($filter['label']);
            echo ' <span aria-hidden="true">×</span>';
            echo '</button>';
        } else {
            // Genre filters are removable
            $remove_url = build_remove_filter_url($filter['type'], $filter['value']);
            echo '<button type="button" class="filter-tag remove-filter-btn" data-href="' . $remove_url . '" aria-label="Rimuovi filtro ' . htmlspecialchars($filter['label']) . '">';
            echo htmlspecialchars($filter['label']);
            echo ' <span aria-hidden="true">×</span>';
            echo '</button>';
        }
    }
    return ob_get_clean();
}

function render_search_hidden_params() {
    $params = $_GET;
    // Remove q since it's in the visible input
    unset($params['q']);

    ob_start();
    foreach ($params as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $v) {
                echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($v) . '">';
            }
        } else {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
    }
    return ob_get_clean();
}

function build_remove_filter_url($type, $value = null) {
    $params = $_GET;

    if ($type === 'genre' && $value) {
        // Remove specific genre from array
        if (isset($params['genre'])) {
            if (is_array($params['genre'])) {
                $params['genre'] = array_filter($params['genre'], function($g) use ($value) {
                    return $g !== $value;
                });
                if (empty($params['genre'])) {
                    unset($params['genre']);
                }
            } else {
                unset($params['genre']);
            }
        }
    } elseif ($type === 'year') {
        unset($params['year_min']);
        unset($params['year_max']);
    } elseif ($type === 'search') {
        unset($params['q']);
    }

    return 'catalogo.php' . (count($params) > 0 ? '?' . http_build_query($params) : '');
}
