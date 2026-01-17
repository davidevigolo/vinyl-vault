<?php

session_start();
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$title = $_POST['title'] ?? null;
$artist = $_POST['artist'] ?? null;
$type = $_POST['type'] ?? null;
$genres = $_POST['genre'] ?? null;

function add_disk_to_collection($title, $artist, $type, $genres)
{
    var_dump($title, $artist, $type, $genres);
    /* Validate inputs */
    if (!$title || !$artist || !$type || !$genres || !is_array($genres) || count($genres) == 0) {
        return false;
    }

    if (trim($title) === '' || trim($type) === '' || trim($artist) === '') {
        return false;
    }
    foreach ($genres as $genre) {
        if (trim($genre) === '') {
            return false;
        }
    }

    if(strlen($title) > 200) {
        return false;
    }

    if(!in_array($type, ['SINGLE', 'EP', 'ALBUM'])) {
        return false;
    }
    /* Insert into database */
    $success = true;
    $connection = DbConnection::get_instance();
    $query = "INSERT INTO disk (title, disk_type) VALUES (?, ?);";
    $query_author = "INSERT INTO disk_author_release (disk_id, author_id) VALUES (?, ?);";
    $query_genre = "INSERT INTO disk_genre_classification (disk_id, genre_name) VALUES (?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    $stmt_author = mysqli_prepare($connection->get_connection(), $query_author);
    $stmt_genre = mysqli_prepare($connection->get_connection(), $query_genre);

    if (!$stmt || !$stmt_author || !$stmt_genre) {
        echo "Errore preparazione statement";
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'ss', $title, $type);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$success) {
        echo "Errore inserimento disco";
        return false;
    }

    $disk_id = mysqli_insert_id($connection->get_connection());
    mysqli_stmt_bind_param($stmt_author, 'ii', $disk_id, $artist);
    $success = mysqli_stmt_execute($stmt_author);
    mysqli_stmt_close($stmt_author);
    if (!$success) {
        echo "Errore inserimento autore disco";
        return false;
    }

    foreach ($genres as $genre) {
        mysqli_stmt_bind_param($stmt_genre, 'is', $disk_id, $genre);
        $success = mysqli_stmt_execute($stmt_genre);
        if (!$success) {
            mysqli_stmt_close($stmt_genre);
            return false;
        }
    }
    mysqli_stmt_close($stmt_genre);

    echo "Fine operazione";

    return $success;
}

$result = add_disk_to_collection($title, $artist, $type, $genres);
// header('Location: ../../add_disk.php?result=' . ($result ? 'success' : 'error'));
exit();
?>