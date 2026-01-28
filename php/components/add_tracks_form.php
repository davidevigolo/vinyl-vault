<?php
include_once 'php/classes/Template.php';
include_once 'php/classes/utils.php';
include_once 'php/classes/DbConnection.php';

function get_disks()
{
    $query = "SELECT id, title FROM disk ORDER BY title ASC";
    $connection = DbConnection::get_instance();
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        return [];
    }
    $disks = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $disks[] = $row;
    }
    return $disks;
}

function get_editions()
{
    $query = "SELECT disk_id, edition_name FROM edition ORDER BY edition_name ASC";
    $connection = DbConnection::get_instance();
    $result = mysqli_query($connection->get_connection(), $query);
    if (!$result) {
        return [];
    }
    $editions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $editions[] = $row;
    }
    return $editions;
}

function get_disk_type($disk_id){
    $connection = DbConnection::get_instance();
    $query = "SELECT disk_type FROM disk WHERE id = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log(mysqli_error($connection->get_connection()));
        return null;
    }
    mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['disk_type'];
    }
    return null;
}

function add_tracks_form($_disk, $_edition, $_titles, $_durations, $errors = []): string
{
    $disks = get_disks();
    $editions = get_editions();
    $edition_options = '';
    $track_form_items = '';

    foreach ($disks as $disk) {
        $edition_options .= '<optgroup label="' . htmlspecialchars($disk['title']) . '" data-disk-id="' . htmlspecialchars($disk['id']) . '">';
        foreach ($editions as $edition) {
            if ($edition['disk_id'] === $disk['id']) {
                $selected = (isset($_edition) && $_edition === $edition['edition_name']) ? ' selected' : '';
                $edition_options .= '<option value="' . htmlspecialchars($edition['edition_name']) . '"' . $selected . '>' . htmlspecialchars($edition['edition_name']) . '</option>';
            }
        }
        $edition_options .= '</optgroup>';
    }
    $first_track_title = isset($_titles[0]) ? htmlspecialchars($_titles[0]) : '';
    $first_track_duration = isset($_durations[0]) ? htmlspecialchars($_durations[0]) : '';
    for ($i = 1; $i < 20; $i++) {
        $track_form_items .= Template::render('static/layout/add_tracks/track_form_item.html', [
            'index' => $i + 1,
            'track_title' => isset($_titles[$i]) ? htmlspecialchars($_titles[$i - 1]) : '',
            'track_duration' => isset($_durations[$i]) ? htmlspecialchars($_durations[$i - 1]) : '',
            'display' => isset($_titles[$i]) ? 'true' : 'false'
        ]);
    }

    $disks = get_disks();
    return Template::render('static/layout/add_tracks/add_tracks_form.html', [
        'disk_options' => implode('', array_map(function ($disk) use($_disk) {
            $selected = (isset($_disk) && intval($_disk) == $disk['id']) ? ' selected' : '';
            return '<option value="' . htmlspecialchars($disk['id']) . '"' . $selected . ' data-disk-type="' . htmlspecialchars(get_disk_type($disk['id'])) . '">' . htmlspecialchars($disk['title']) .' (' . htmlspecialchars(get_disk_type_display_names()[get_disk_type($disk['id'])]) . ') </option>';
        }, $disks)),
        'edition_options' => $edition_options,
        'track_form_items' => $track_form_items,
        'first_track_title' => $first_track_title,
        'first_track_duration' => $first_track_duration,
        'errors' => isset($errors) && !empty($errors) ? '<ul>' . implode('', array_map(fn($error) => '<li>' . htmlspecialchars($error) . '</li>', $errors)) . '</ul>' : ''
    ]);
}