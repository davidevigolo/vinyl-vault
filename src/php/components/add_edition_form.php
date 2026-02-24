<?php
include_once 'php/classes/Template.php';
include_once 'php/classes/utils.php';
include_once 'php/classes/DbConnection.php';

function get_disks() {
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

function add_edition_form($_disk, $name, $release_date, $_country, $is_standard_edition, $errors) {
    $nationality_codes = get_nationality_codes();
    $disks = get_disks();
    return Template::render('static/layout/add_edition/add_edition_form.html', [
        'country_options' => implode('', array_map(function ($code, $country) use ($_country) {
            $select = (isset($_country) && $_country === $code) ? ' selected' : '';
            return '<option value="' . htmlspecialchars($code) . '"' . $select . '>' . htmlspecialchars($country) . '</option>';
        }, array_keys($nationality_codes), array_values($nationality_codes))),
        'disk_options' => implode('', array_map(function ($disk) use ($_disk) {
            $select = (isset($_disk) && $_disk == $disk['id']) ? ' selected' : '';
            return '<option value="' . htmlspecialchars($disk['id']) . '"' . $select . '>' . htmlspecialchars($disk['title']) . '</option>';
        }, $disks)),
        'name' => htmlspecialchars($name ?? ''),
        'release_date' => htmlspecialchars($release_date ?? ''),
        'standard_edition' => isset($is_standard_edition) && $is_standard_edition ? 'checked' : '',
        'name_enabled' => isset($is_standard_edition) && $is_standard_edition ? 'disabled' : '',
        'errors' => isset($errors) && !empty($errors) ? '<div id="add-edition-error-container" aria-live="assertive" class="error-message">Sono stati riscontrati i seguenti errori: <ul>' . implode('', array_map(fn($error) => '<li>' . htmlspecialchars($error) . '</li>', $errors)) . '</ul></div>' : '',
    ]);
}