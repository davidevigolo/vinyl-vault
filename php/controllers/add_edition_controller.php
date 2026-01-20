<?php
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$release_date = $_POST['release-date'] ?? null;
$disk_id = $_POST['disk'] ?? null;
$name = $_POST['name'] ?? null;
$country = $_POST['country'] ?? null;
$image = $_FILES['photo'] ?? null;

function addEdition($disk_id, $name, $release_date, $country, $image)
{
    if (!$disk_id || !$name || !$release_date || !$country || !$image) {
        return false;
    }
    if ($image['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    // Get file extension
    $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'webp'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    if ($image['size'] > 2 * 1024 * 1024) { // 2MB limit
        return false;
    }

    $name = trim($name);
    $regex = "/^[a-zA-ZÀ-ÿ '´`^¨~-]{1,100}$/u";
    if (preg_match($regex, $name) !== 1) {
        return false;
    }
    if (in_array($country, array_keys(get_nationality_codes())) === false) {
        return false;
    }

    $connection = DbConnection::get_instance();
    // Insert edition without image_path first
    $query = "INSERT INTO edition (disk_id, edition_name, release_date, country) VALUES (?, ?, ?, ?);";
    mysqli_begin_transaction($connection->get_connection());
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        mysqli_rollback($connection->get_connection());
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'isss', $disk_id, $name, $release_date, $country);
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        mysqli_rollback($connection->get_connection());
        return false;
    }
    // Get the inserted edition ID
    $edition_id = mysqli_insert_id($connection->get_connection());
    mysqli_stmt_close($stmt);
    // Generate image path with edition ID
    $image_path = 'edition_' . $edition_id . '.' . $file_extension;
    // Update edition with image_path
    $update_query = "UPDATE edition SET image_path = ? WHERE edition_id = ?;";
    $update_stmt = mysqli_prepare($connection->get_connection(), $update_query);
    if (!$update_stmt) {
        mysqli_rollback($connection->get_connection());
        return false;
    }
    mysqli_stmt_bind_param($update_stmt, 'si', $image_path, $edition_id);
    $success = mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
    if ($success) {
        // Resolve absolute upload path and ensure directory exists
        $upload_dir = dirname(__DIR__, 2) . '/assets/uploaded_images';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0775, true);
        }
        if (!is_writable($upload_dir)) {
            mysqli_rollback($connection->get_connection());
            return false;
        }

        $file_tmp = $image['tmp_name'];
        $destination = $upload_dir . '/' . $image_path;
        $move_ok = move_uploaded_file($file_tmp, $destination);
        $success = $success && $move_ok;
    }
    if (!$success) {
        mysqli_rollback($connection->get_connection());
        return false;
    }
    mysqli_commit($connection->get_connection());
    return true;
}

$success = addEdition($disk_id, $name, $release_date, $country, $image);
header('Location: ../pages/add_edition.php?result=' . ($success ? 'success' : 'fail'));
exit();
?>