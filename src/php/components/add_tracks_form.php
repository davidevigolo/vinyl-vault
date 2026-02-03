<?php
include_once 'php/classes/Template.php';
include_once 'php/classes/utils.php';
include_once 'php/classes/DbConnection.php';

function get_disks()
{
    $query = "SELECT id, title FROM disk WHERE id IN (SELECT DISTINCT disk_id FROM edition) ORDER BY title ASC";
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

function get_disk_type($disk_id)
{
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

function get_last_track_number($disk_id, $edition_name)
{
    $connection = DbConnection::get_instance();
    $query = "SELECT MAX(track_number) AS last_track_number FROM edition_track_part_of WHERE disk_id = ? AND edition_name = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log(mysqli_error($connection->get_connection()));
        return 0;
    }
    mysqli_stmt_bind_param($stmt, 'is', $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return intval($row['last_track_number']);
    }
    return 0;
}

function get_track_number_by_disk_type($disk_id){
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
        return get_max_tracks_by_type($row['disk_type']);
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
    $first_track_index = get_last_track_number($_disk, $_edition);
    $input_rules = '<ul class="input-examples">
                    <li><abbr title="ad esempio">es.</abbr> "Titolo traccia 1"</li>
                    <li>Massimo 200 caratteri</li>
                    <li>Caratteri consentiti: lettere, numeri e spazi</li>
                    </ul>';
    $_titles[0] = $_titles[0] ? htmlspecialchars($_titles[0]) : '';
    $_durations[0] = $_durations[0] ? htmlspecialchars($_durations[0]) : '0';
    $max_tracks = get_track_number_by_disk_type($_disk);
    if($max_tracks <= $first_track_index){
        $track_form_items = '<p aria-live="assertive">Questo disco ha già il numero massimo di tracce.</p>';
    }
    for ($i = $first_track_index; $i < $max_tracks; $i++) {
        $track_form_items .= Template::render('static/layout/add_tracks/track_form_item.html', [
            'index' => $i + 1,
            'track_title' => isset($_titles[$i]) ? htmlspecialchars($_titles[$i]) : '',
            'track_duration' => isset($_durations[$i]) ? 'value="' . htmlspecialchars($_durations[$i]) . '"' : '',
            'display' => isset($_titles[$i]) || $i == $first_track_index ? 'true' : 'false',
            'required' => $i === $first_track_index ? 'required' : '',
            'input_rules' => $i === $first_track_index ? $input_rules : ''
        ]);
    }

    $disks = get_disks();
    return Template::render('static/layout/add_tracks/add_tracks_form.html', [
        'disk_options' => implode('', array_map(function ($disk) use ($_disk) {
            $selected = (isset($_disk) && intval($_disk) == $disk['id']) ? ' selected' : '';
            return '<option value="' . htmlspecialchars($disk['id']) . '"' . $selected . ' data-disk-type="' . htmlspecialchars(get_disk_type($disk['id'])) . '">' . htmlspecialchars($disk['title']) . ' (' . htmlspecialchars(get_disk_type_display_names()[get_disk_type($disk['id'])]) . ') </option>';
        }, $disks)),
        'edition_options' => $edition_options,
        'track_form_items' => $track_form_items,
        'selected_disk' => htmlspecialchars($_disk ?? ''),
        'selected_edition' => htmlspecialchars($_edition ?? ''),
        'errors' => isset($errors) && !empty($errors) ? '<div id="add-tracks-error-container" aria-live="assertive" class="error-message">Sono stati riscontrati i seguenti errori: <ul>' . implode('', array_map(fn($error) => '<li>' . htmlspecialchars($error) . '</li>', $errors)) . '</ul></div>' : ''
    ]);
}