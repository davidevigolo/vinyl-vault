<?php

include_once 'php/classes/DbConnection.php';
include_once 'php/classes/utils.php';

function add_disk($title, $artist, $type, $genres): array
{

    /* Validate inputs */
    if (!$title || !$artist || !$type || !$genres || !is_array($genres) || count($genres) == 0) {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }

    if (trim($title) === '' || trim($type) === '' || trim($artist) === '') {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }

    $regex = "/^[a-zA-Z0-9À-ÿ '´`^¨~\-,.!?()]{1,200}$/u";
    if (preg_match($regex, $title) !== 1) {
        return ['success' => false, 'error' => 'Formato titolo non valido', 'fields_to_reset' => ['title']];
    }

    foreach ($genres as $genre) {
        if (trim($genre) === '') {
            return ['success' => false, 'error' => 'Uno o più generi non sono validi', 'fields_to_reset' => ['genre']];
        }
    }

    if(count($genres) > 6) {
        return ['success' => false, 'error' => 'Puoi inserire fino ad un massimo di 6 generi per disco', 'fields_to_reset' => ['genre'] ];
    }

    $array_unique_genres = array_unique($genres);

    if(count($array_unique_genres) !== count($genres)) {
        return ['success' => false, 'error' => 'Hai inserito almeno due generi identici per questo disco. Rimuovi i duplicati e riprova.', 'fields_to_reset' => ['genre'] ];
    }

    if (strlen($title) > 200) {
        return ['success' => false, 'error' => 'Titolo troppo lungo', 'fields_to_reset' => ['title']];
    }

    if (!in_array($type, ['SINGLE', 'EP', 'ALBUM'])) {
        return ['success' => false, 'error' => 'Tipo di disco non valido', 'fields_to_reset' => ['type']];
    }

    /* Insert into database */
    $success = true;
    $connection = DbConnection::get_instance();
    mysqli_begin_transaction($connection->get_connection());
    $query = "INSERT INTO disk (title, disk_type) VALUES (?, ?);";
    $query_author = "INSERT INTO disk_author_release (disk_id, author_id) VALUES (?, ?);";
    $query_genre = "INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES (?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    $stmt_author = mysqli_prepare($connection->get_connection(), $query_author);
    $stmt_genre = mysqli_prepare($connection->get_connection(), $query_genre);

    if (!$stmt || !$stmt_author || !$stmt_genre) {
        error_log(mysqli_error($connection->get_connection()));
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un disco già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_stmt_bind_param($stmt, 'ss', $title, $type);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$success) {
        error_log(mysqli_error($connection->get_connection()));
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un disco già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }

    $disk_id = mysqli_insert_id($connection->get_connection());
    mysqli_stmt_bind_param($stmt_author, 'ii', $disk_id, $artist);
    $success = mysqli_stmt_execute($stmt_author);
    mysqli_stmt_close($stmt_author);
    if (!$success) {
        error_log(mysqli_error($connection->get_connection()));
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un disco già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }

    foreach ($genres as $genre) {
        mysqli_stmt_bind_param($stmt_genre, 'is', $disk_id, $genre);
        $success = mysqli_stmt_execute($stmt_genre);
        if (!$success) {
            error_log(mysqli_error($connection->get_connection()));
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Hai inserito almeno due generi identici per questo disco. Rimuovi i duplicati e riprova.', 'fields_to_reset' => ['genre'] ];
        }
    }
    mysqli_stmt_close($stmt_genre);
    mysqli_commit($connection->get_connection());

    return ['success' => true];
}