<?php

require 'php/classes/resources.php';

include 'php/components/catalog_vinyls.php';

$genre_filter = isset($_GET['genre']) ? (is_array($_GET['genre']) ? $_GET['genre'] : [$_GET['genre']]) : null;
$year_min = isset($_GET['year_min']) ? intval($_GET['year_min']) : null;
$year_max = isset($_GET['year_max']) ? intval($_GET['year_max']) : null;
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'collected';
$search_query = isset($_GET['q']) ? trim($_GET['q']) : null;

// load ALL results (with search if provided)
$catalog_data = get_catalog_vinyls($genre_filter, $year_min, $year_max, $sort_by, 300, $search_query);
$total_count = count($catalog_data);

$genres_list = get_all_genres();
$year_range = get_year_range();

$active_filters = [];

// Add search filter first if present
if ($search_query) {
    $active_filters[] = [
        'label' => 'Ricerca: "' . $search_query . '"',
        'type' => 'search',
        'value' => $search_query
    ];
}

// Always show year filter with current values
$display_year_min = $year_min ?: $year_range['min'];
$display_year_max = $year_max ?: $year_range['max'];
$year_label = "$display_year_min - $display_year_max";
$active_filters[] = [
    'label' => $year_label,
    'type' => 'year',
    'value' => ''
];

// Add genre filters after
if ($genre_filter && is_array($genre_filter)) {
    foreach ($genre_filter as $genre) {
        $active_filters[] = [
            'label' => $genre,
            'type' => 'genre',
            'value' => $genre
        ];
    }
}

// Generate reset URL - complete reset to defaults
$reset_url = 'catalogo.php';

include 'php/components/header.php';
include 'php/components/footer.php';

function render_year_options($start_year, $end_year, $selected_year) {
    $options = '';
    for ($i = $start_year; $i <= $end_year; $i++) {
        $selected = $i == $selected_year ? 'selected' : '';
        $options .= "<option value=\"$i\" $selected>$i</option>";
    }
    return $options;
}

$year_min_options = render_year_options($year_range['min'], $year_range['max'], $year_min ?: $year_range['min']);
$year_max_options = render_year_options($year_range['min'], $year_range['max'], $year_max ?: $year_range['max']);

$admin_buttons = '<div id="admin-buttons-container">
                  <p id="admin-options-title">Opzioni admin</p>
                  <a href="add_artist.php" class="btn-secondary" aria-label="Vai alla pagina di aggiunta artista">Aggiungi Artista</a>
                  <a href="add_disk.php" class="btn-secondary" aria-label="Vai alla pagina di aggiunta disco">Aggiungi Disco</a>
                  <a href="add_edition.php" class="btn-secondary" aria-label="Vai alla pagina di aggiunta edizione">Aggiungi Edizione</a>
                  <a href="add_genre.php" class="btn-secondary" aria-label="Vai alla pagina di aggiunta genere">Aggiungi Genere</a>
                  </div>';

echo Template::render(
    'static/catalogo.html',
    [
        'head' => Template::render('static/layout/head.html',[]),
        'header' => _header(),
        'footer' => footer(),
        'catalog_vinyls' => render_catalog_cards($catalog_data, $search_query),
        'genres_options' => render_genres_checkboxes($genres_list),
        'genres_options_mobile' => render_genres_checkboxes($genres_list, 'mobile-'),
        'year_min' => $year_range['min'],
        'year_max' => $year_range['max'],
        'year_min_selected' => $year_min ?: $year_range['min'],
        'year_max_selected' => $year_max ?: $year_range['max'],
        'year_min_options' => $year_min_options,
        'year_max_options' => $year_max_options,
        'reset_url' => $reset_url,
        'active_filters' => render_active_filters($active_filters),
        'sort_selected_collected' => $sort_by === 'collected' ? 'selected' : '',
        'sort_selected_recent' => $sort_by === 'recent' ? 'selected' : '',
        'sort_selected_az' => $sort_by === 'az' ? 'selected' : '',
        'total_results' => $total_count,
        'has_more_display' => $total_count > 6 ? '' : 'style="display:none"',
        'search_value' => htmlspecialchars($search_query ?? ''),
        'search_results_message' => $search_query ? 'Risultati per "' . htmlspecialchars($search_query) . '"' : '',
        'search_hidden_params' => render_search_hidden_params(),
        'search_hidden_input' => $search_query ? '<input type="hidden" name="q" value="' . htmlspecialchars($search_query) . '">' : '',
        'clear_search_hidden' => $search_query ? '' : 'hidden',
        'role' => $total_count > 0 ? 'feed' : 'alert',
        'admin_buttons' => isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1 ? $admin_buttons : ''
    ]
);
