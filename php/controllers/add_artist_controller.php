<?php
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$name = $_POST['name'] ?? null;
$nationality = $_POST['nationality'] ?? null;
$image = $_FILES['photo'] ?? null;

function add_artist_to_collection($name, $nationality, $image): bool
{
    if ($image === null || $image['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $name = trim($name);
    $regex = "/^[a-zA-ZÀ-ÿ '´`^¨~-]{1,100}$/u";
    if (preg_match($regex, $name) !== 1) {
        return false;
    }
    if ($name === '' || strlen($name) > 100) {
        return false;
    }
    if (in_array($nationality, array_keys(get_nationality_codes())) === false) {
        return false;
    }
    // Get file extension
    $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'webp'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    if ($image['size'] > 8 * 1024 * 1024) { // 8MB limit
        return false;
    }

    $connection = DbConnection::get_instance();
    
    // Insert artist without image_path first
    $query = "INSERT INTO author (author_name, nationality) VALUES (?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'ss', $name, $nationality);
    $success = mysqli_stmt_execute($stmt);
    
    if (!$success) {
        mysqli_stmt_close($stmt);
        return false;
    }
    
    // Get the inserted artist ID
    $artist_id = mysqli_insert_id($connection->get_connection());
    mysqli_stmt_close($stmt);
    
    // Generate image path with artist ID
    $image_path = 'artist_' . $artist_id . '.' . $file_extension;
    
    // Update the record with image path
    $query = "UPDATE author SET image_path = ? WHERE id = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'si', $image_path, $artist_id);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($success) {
        // Resolve absolute upload path and ensure directory exists
        $upload_dir = dirname(__DIR__, 2) . '/assets/uploaded_images';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }
        if (!is_writable($upload_dir)) {
            return false;
        }

        $file_tmp = $image['tmp_name'];
        $destination = $upload_dir . '/' . $image_path;
        $move_ok = move_uploaded_file($file_tmp, $destination);
        $success = $success && $move_ok;
    }

    return $success;
}

$result = add_artist_to_collection($name, $nationality, $image);

header('Location: ../../add_artist.php?result=' . ($result ? 'success' : 'fail'));