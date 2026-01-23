<?php
include_once 'php/classes/DbConnection.php';
include_once 'php/classes/utils.php';

function add_artist_to_collection($name, $nationality, $image): array
{
    if(!$name || !$nationality || !$image) {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }
    if ($image['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Errore durante il caricamento dell\'immagine, controlla il formato e la dimensione del file'];
    }
    $name = trim($name);
    $regex = "/^[a-zA-ZÀ-ÿ '´`^¨~-]{1,100}$/u";
    if (preg_match($regex, $name) !== 1) {
        return ['success' => false, 'error' => 'Formato nome non valido', 'fields_to_reset' => ['name']];
    }
    if (in_array($nationality, array_keys(get_nationality_codes())) === false) {
        return ['success' => false, 'error' => 'Nazionalità non valida', 'fields_to_reset' => ['nationality'] ];
    }
    // Get file extension
    $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'webp'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'error' => 'Estensione file non valida', 'fields_to_reset' => ['photo'] ];
    }

    if ($image['size'] > 2 * 1024 * 1024) { // 2MB limit
        return ['success' => false, 'error' => 'Dimensione file superiore al limite', 'fields_to_reset' => ['photo'] ];
    }

    $connection = DbConnection::get_instance();
    mysqli_begin_transaction($connection->get_connection());
    
    // Insert artist without image_path first
    $query = "INSERT INTO author (author_name, nationality) VALUES (?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un artista già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_stmt_bind_param($stmt, 'ss', $name, $nationality);
    $success = mysqli_stmt_execute($stmt);
    
    if (!$success) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un artista già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
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
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore, probabilmente stai provando ad inserire un artista già presente nel nostro database. Se il problema persiste contattaci a vinylvault@gmail.com'];
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
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Stiamo riscontrando dei problemi con le immagini, non ti preoccupare, il problema verrà risolto a breve!'];
        }

        $file_tmp = $image['tmp_name'];
        $destination = $upload_dir . '/' . $image_path;
        $move_ok = move_uploaded_file($file_tmp, $destination);
        $success = $success && $move_ok;
    }
    if(!$success) {
        mysqli_rollback($connection->get_connection());
        return ['success' => false, 'error' => 'Errore durante il salvataggio dell\'immagine, probabilmente è già presente un\'immagine per questo artista. Se il problema persiste contattaci a vinylvault@gmail.com'];
    }
    mysqli_commit($connection->get_connection());
    return ['success' => true];
}
?>