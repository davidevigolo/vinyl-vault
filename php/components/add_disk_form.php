<?php
include_once 'php/classes/DbConnection.php';

function get_artists()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT DISTINCT id,author_name,nationality FROM author ORDER BY author_name ASC;";
    $result = mysqli_query($connection->get_connection(), $query);

    if (!$result) {
        return [];
    }

    $artists = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $artists[] = ['id' => $row['id'], 'author_name' => $row['author_name'], 'nationality' => $row['nationality']];
    }
    mysqli_free_result($result);
    return $artists;
}

function get_genre_options()
{
    $connection = DbConnection::get_instance();
    $query = "SELECT DISTINCT genre_name FROM genre ORDER BY genre_name ASC;";
    $result = mysqli_query($connection->get_connection(), $query);

    if (!$result) {
        return [];
    }

    $genres = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $genres[] = $row['genre_name'];
    }
    mysqli_free_result($result);
    return $genres;
}

function add_disk_form($title, $_artist, $type, $_genres, $errors): string
{
    $artists = get_artists();

    // Group artists by nationality
    $grouped_artists = [];
    foreach ($artists as $artist) {
        $nationality = $artist['nationality'];
        if (!isset($grouped_artists[$nationality])) {
            $grouped_artists[$nationality] = [];
        }
        $grouped_artists[$nationality][] = $artist;
    }

    // Sort nationalities for consistent display
    ksort($grouped_artists);

    // Build HTML with optgroups
    $artist_options = '';
    foreach ($grouped_artists as $nationality => $artists_in_group) {
        $artist_options .= '<optgroup label="' . htmlspecialchars(strtoupper($nationality)) . '">';
        foreach ($artists_in_group as $artist) {
            $selected = ($_artist !== null && $_artist == $artist['id']) ? ' selected' : '';
            if ($artist['nationality'] != "it") {
                $artist_options .= '<option value="' . htmlspecialchars($artist['id']) . '" lang="' . htmlspecialchars($artist['nationality']) . '"' . $selected . '>' . htmlspecialchars($artist['author_name']) . '</option>';
            } else {
                $artist_options .= '<option value="' . htmlspecialchars($artist['id']) . '"' . $selected . '>' . htmlspecialchars($artist['author_name']) . '</option>';
            }
        }
        $artist_options .= '</optgroup>';
    }

    $type_options = [
        'SINGLE' => 'Singolo',
        'EP' => 'EP',
        'ALBUM' => 'Album'
    ];
    $type_options = array_map(function ($value, $label) use ($type) {
        $selected = ($value === $type) ? ' selected' : '';
        return "<option value=\"" . htmlspecialchars($value) . "\"" . $selected . ">" . htmlspecialchars($label) . "</option>";
    }, array_keys($type_options), array_values($type_options));

    $genres = get_genre_options();
    $genre = array_shift($_genres);
    $genre_options = array_map(function ($genre_option) use ($genre) {
        $selected = ($genre_option === $genre) ? ' selected' : '';
        return "<option value=\"" . htmlspecialchars($genre_option) . "\"" . $selected . ">" . htmlspecialchars($genre_option) . "</option>";
    }, $genres);

    $additional_genres = [];
    for($i = 0; $i < 5; $i++) {
        if(count($_genres) > 0){
            $genre = array_shift($_genres);
            $additional_genre_options = array_map(function ($genre_option) use ($genre) {
                $selected = ($genre_option === $genre) ? ' selected' : '';
                return "<option value=\"" . htmlspecialchars($genre_option) . "\"" . $selected . ">" . htmlspecialchars($genre_option) . "</option>";
            }, $genres);
            $additional_genres[] = Template::render('static/layout/add_disk/genre_form_item.html', [
                'index' => $i + 1,
                'additional_genre_options' => implode('', $additional_genre_options)
            ]);
        } else {
            $additional_genre_options = array_map(function ($genre_option) {
                return "<option value=\"" . htmlspecialchars($genre_option) . "\"" . ">" . htmlspecialchars($genre_option) . "</option>";
            }, $genres);
            $additional_genres[] = Template::render('static/layout/add_disk/genre_form_item.html', [
                'index' => $i + 1,
                'additional_genre_options' => implode('', $additional_genre_options)
            ]);
        }
    }
    return Template::render('static/layout/add_disk/add_disk_form.html', [
        'artist_options' => $artist_options,
        'type_options' => implode('', $type_options),
        'genre_options' => implode('', $genre_options),
        'additional_genres' => implode('', $additional_genres),
        'errors' => isset($errors) && !empty($errors) ? '<ul>' . implode('', array_map(fn($error) => '<li>' . htmlspecialchars($error) . '</li>', $errors)) . '</ul>' : '',
        'title' => isset($title) ? htmlspecialchars($title) : ''
    ]);
}