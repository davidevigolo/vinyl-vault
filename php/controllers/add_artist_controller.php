<?php

session_start();
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$name = $_POST['name'] ?? null;
$nationality = $_POST['nationality'] ?? null;
$image_path = $_FILES['photo']['name'] ?? null;
function add_artist_to_collection($name, $nationality, $image_path)
{
    $name = trim($name);
    if ($name === '' || strlen($name) > 100) {
        return false;
    }
    if (in_array($nationality, array_keys(get_nationality_codes())) === false) {
        return false;
    }
    if ($image_path === '' || strlen($image_path) > 255) {
        return false;
    }

    $connection = DbConnection::get_instance();
    $query = "INSERT INTO author (author_name, nationality, image_path) VALUES (?, ?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'sss', $name, $nationality, $image_path);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $success;
}

$result = add_artist_to_collection($name, $nationality, $image_path);

header('Location: ../../add_artist.php?result=' . ($result ? 'success' : 'fail'));