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

function add_edition_form($result)
{
    if ($result === 'success') {
        return Template::render('static/layout/add_edition/add_edition_success.html', []);
    } else {
        $nationality_codes = get_nationality_codes();
        $disks = get_disks();
        return Template::render('static/layout/add_edition/add_edition_form.html', [
            'country_options' => implode('', array_map(function ($code, $country) {
                return '<option value="' . htmlspecialchars($code) . '">' . htmlspecialchars($country) . '</option>';
            }, array_keys($nationality_codes), array_values($nationality_codes))),
            'disk_options' => implode('', array_map(function ($disk) {
                return '<option value="' . htmlspecialchars($disk['id']) . '">' . htmlspecialchars($disk['title']) . '</option>';
            }, $disks)),
        ]);
    }
}