<?php
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

session_start();
check_user_logged_in();

function add_edition($disk_id, $name, $release_date, $country, $is_standard_edition, $image)
{
    if (!$disk_id || (!$name && !$is_standard_edition) || !$release_date || !$country || !$image) {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }
    if ($is_standard_edition) {
        $name = 'Standard Edition';
    }
    if ($image['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Errore durante il caricamento dell\'immagine'];
    }
    // Get file extension
    $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'webp'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'error' => 'Formato immagine non supportato'];
    }

    if ($image['size'] > 2 * 1024 * 1024) { // 2MB limit
        return ['success' => false, 'error' => 'L\'immagine supera la dimensione massima di 2MB'];
    }

    $name = trim($name);
    $regex = "/^[a-zA-ZÀ-ÿ '´`^¨~-]{1,100}$/u";
    if (preg_match($regex, $name) !== 1) {
        return ['success' => false, 'error' => 'Nome edizione non valido', 'fields_to_reset' => ['name']];
    }
    if (in_array($country, array_keys(get_nationality_codes())) === false) {
        return ['success' => false, 'error' => 'Paese di rilascio non valido', 'fields_to_reset' => ['country']];
    }
    if (!in_array($disk_id, get_all_disk_ids())) {
        return ['success' => false, 'error' => 'ID disco non valido', 'fields_to_reset' => ['disk']];
    }
    // Check that the release year is not in the future
    $release_year = (int) date('Y', strtotime($release_date));
    $current_year = (int) date('Y');
    if ($release_year > $current_year) {
        return ['success' => false, 'error' => 'La data di rilascio non può essere oltre l\'anno corrente', 'fields_to_reset' => ['release-date']];
    }

    $connection = DbConnection::get_instance();
    // Insert edition without image_path first
    $query = "INSERT INTO edition (disk_id, edition_name, release_date, country) VALUES (?, ?, ?, ?);";
    mysqli_begin_transaction($connection->get_connection());
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento dell\'edizione, probabilmente stai provando ad inserire un\'edizione già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_stmt_bind_param($stmt, 'isss', $disk_id, $name, $release_date, $country);
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento dell\'edizione, probabilmente stai provando ad inserire un\'edizione già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    // Get the inserted edition ID
    mysqli_stmt_close($stmt);
    // Generate image path with edition ID
    $image_path = 'edition_' . $disk_id . '_' . $name . '.' . $file_extension;
    // Update edition with image_path
    $update_query = "UPDATE edition SET image_path = ? WHERE edition_name = ?;";
    $update_stmt = mysqli_prepare($connection->get_connection(), $update_query);
    if (!$update_stmt) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento dell\'edizione, probabilmente stai provando ad inserire un\'edizione già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_stmt_bind_param($update_stmt, 'ss', $image_path, $name);
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
            return ['success' => false, 'error' => 'Stiamo riscontrando dei problemi con le immagini, non ti preoccupare, il problema verrà risolto a breve!'];
        }

        $file_tmp = $image['tmp_name'];
        $destination = $upload_dir . '/' . $image_path;
        $move_ok = move_uploaded_file($file_tmp, $destination);
        $success = $success && $move_ok;
    }
    if (!$success) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Errore durante il salvataggio dell\'immagine, probabilmente è già presente un\'immagine per questa edizione. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_commit($connection->get_connection());
    return ['success' => true];
}

$disk_id = $_POST['disk'] ?? null;
$name = $_POST['name'] ?? null;
$release_date = $_POST['release-date'] ?? null;
$country = $_POST['country'] ?? null;
$is_standard_edition = isset($_POST['standard-edition']) ? true : false;
$image = $_FILES['photo'] ?? null;
$_SESSION['add_edition_result'] = add_edition($disk_id, $name, $release_date, $country, $is_standard_edition, $image);
$_SESSION['add_edition_result']['disk'] = in_array('disk', $_SESSION['add_edition_result']['fields_to_reset'] ?? []) ? '' : $disk_id;
$_SESSION['add_edition_result']['name'] = in_array('name', $_SESSION['add_edition_result']['fields_to_reset'] ?? []) ? '' : $name;
$_SESSION['add_edition_result']['release_date'] = in_array('release-date', $_SESSION['add_edition_result']['fields_to_reset'] ?? []) ? '' : $release_date;
$_SESSION['add_edition_result']['country'] = in_array('country', $_SESSION['add_edition_result']['fields_to_reset'] ?? []) ? '' : $country;
$_SESSION['add_edition_result']['is_standard_edition'] = in_array('is_standard_edition', $_SESSION['add_edition_result']['fields_to_reset'] ?? []) ? false : $is_standard_edition;
header('Location: ../../add_edition.php');
exit();