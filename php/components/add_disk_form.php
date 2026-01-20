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

function add_disk_form($result)
{
    if ($result === 'success') {
        return Template::render('static/layout/add_disk/add_disk_success.html', []);
    } else {
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
                if ($artist['nationality'] != "it") {
                    $artist_options .= '<option value="' . htmlspecialchars($artist['id']) . '" lang="' . htmlspecialchars($artist['nationality']) . '">' . htmlspecialchars($artist['author_name']) . '</option>';
                } else {
                    $artist_options .= '<option value="' . htmlspecialchars($artist['id']) . '">' . htmlspecialchars($artist['author_name']) . '</option>';
                }
            }
            $artist_options .= '</optgroup>';
        }

        $genre_options = get_genre_options();
        $genre_options = array_map(function ($genre) {
            return "<option value=\"" . htmlspecialchars($genre) . "\">" . htmlspecialchars($genre) . "</option>";
        }, $genre_options);

        return Template::render('static/layout/add_disk/add_disk_form.html', [
            'artist_options' => $artist_options,
            'genre_options' => implode('', $genre_options),
        ]);
    }
}