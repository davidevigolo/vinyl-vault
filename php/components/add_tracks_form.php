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

function add_tracks_form($result)
{
    $disks = get_disks();
    $editions = get_editions();
    $edition_options = '';
    $track_form_items = '';
    foreach ($disks as $disk) {
        $edition_options .= '<optgroup label="' . htmlspecialchars($disk['title']) . '" data-disk-id="' . htmlspecialchars($disk['id']) . '">';
        foreach ($editions as $edition) {
            if ($edition['disk_id'] === $disk['id']) {
                $edition_options .= '<option value="' . htmlspecialchars($edition['edition_name']) . '">' . htmlspecialchars($edition['edition_name']) . '</option>';
            }
        }
        $edition_options .= '</optgroup>';
    }
    for ($i = 1; $i <= 20; $i++) {
        $track_form_items .= Template::render('static/layout/add_tracks/track_form_item.html', [
            'index' => $i + 1,
        ]);
    }
    if ($result === 'success') {
        return Template::render('static/layout/add_tracks/add_tracks_success.html', []);
    } else {
        $nationality_codes = get_nationality_codes();
        $disks = get_disks();
        return Template::render('static/layout/add_tracks/add_tracks_form.html', [
            'disk_options' => implode('', array_map(function ($disk) {
                return '<option value="' . htmlspecialchars($disk['id']) . '">' . htmlspecialchars($disk['title']) . '</option>';
            }, $disks)),
            'edition_options' => $edition_options,
            'track_form_items' => $track_form_items,
        ]);
    }
}