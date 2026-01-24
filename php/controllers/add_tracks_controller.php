<?php
include_once 'php/classes/DbConnection.php';
include_once 'php/classes/utils.php';

check_user_logged_in();

function get_editions_for_disk($disk_id): array
{
    $connection = DbConnection::get_instance();
    $query = "SELECT edition_name FROM edition WHERE disk_id = ? ORDER BY edition_name ASC;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log(mysqli_error($connection->get_connection()));
        return [];
    }
    $success = mysqli_stmt_bind_param($stmt, 'i', $disk_id);
    if (!$success) {
        error_log(mysqli_error($connection->get_connection()));
        return [];
    }
    $success = mysqli_stmt_execute($stmt);
    if (!$success) {
        error_log(mysqli_error($connection->get_connection()));
        return [];
    }
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $edition_name);
    $editions = [];
    while (mysqli_stmt_fetch($stmt)) {
        $editions[] = $edition_name;
    }
    mysqli_stmt_close($stmt);
    return $editions;
}

function add_tracks($disk, $edition, $titles, $durations): array
{
    if (!$disk || !$edition || empty($titles) || !is_array($titles) || empty($durations) || !is_array($durations) || count($titles) !== count($durations)) {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }

    if(!in_array($disk, get_all_disk_ids())) {
        return ['success' => false, 'error' => 'Il disco selezionato non esiste sul database', 'fields_to_reset' => ['disk', 'edition']];
    }

    if(!in_array($edition, get_editions_for_disk($disk))) {
        return ['success' => false, 'error' => 'L\'edizione selezionata non esiste per il disco selezionato', 'fields_to_reset' => ['edition']];
    }

    $count = count($titles);
    for ($i = 0; $i < $count; $i++) {
        $track_name = trim($titles[$i]);
        $duration = trim($durations[$i]);
        if (empty($track_name)) {
            return ['success' => false, 'error' => 'Il titolo della traccia non può essere vuoto'];
        }
        $regex = "/^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]{1,200}$/u";
        if (preg_match($regex, $track_name) !== 1) {
            return ['success' => false, 'error' => 'Il titolo della traccia contiene caratteri non validi'];
        }
        if ($duration < 0 || $duration > 32767) { //limit of SMALLINT in database
            return ['success' => false, 'error' => 'La durata della traccia non è valida'];
        }
    }

    $connection = DbConnection::get_instance();
    $query = "INSERT INTO track (title, duration_seconds) VALUES (?, ?);";
    $link_query = "INSERT INTO edition_track_part_of (disk_id, edition_name, track_id, track_number) VALUES (?, ?, ?, ?);";
    $check_duplicate_track_query = "SELECT COUNT(*) as count FROM edition_track_part_of etp
        JOIN track t ON etp.track_id = t.id
        WHERE etp.disk_id = ? AND etp.edition_name = ? AND t.title = ?;";
    mysqli_begin_transaction($connection->get_connection());

    foreach ($titles as $index => $track_name) {
        $track_name = trim($track_name);
        $duration = trim($durations[$index]);
        $track_number = $index + 1;
        $stmt = mysqli_prepare($connection->get_connection(), $query);
        if (!$stmt) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }

        $success = mysqli_stmt_bind_param($stmt, 'si', $track_name, $duration);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $track_id = mysqli_insert_id($connection->get_connection());
        mysqli_stmt_close($stmt);
        $stmt_check = mysqli_prepare($connection->get_connection(), $check_duplicate_track_query);
        if (!$stmt_check) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $success = mysqli_stmt_bind_param($stmt_check, 'iss', $disk, $edition, $track_name);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $success = mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $count);
        mysqli_stmt_fetch($stmt_check);
        if ($count > 1) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'La traccia "' . htmlspecialchars($track_name) . '" è già presente per questa edizione. Titoli delle tracce devono essere univoci all\'interno di una stessa edizione.'];
        }
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        mysqli_stmt_close($stmt_check);
        $stmt_link = mysqli_prepare($connection->get_connection(), $link_query);
        if (!$stmt_link) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $success = mysqli_stmt_bind_param($stmt_link, 'issi', $disk, $edition, $track_id, $track_number);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        $success = mysqli_stmt_execute($stmt_link);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della traccia, probabilmente stai provando ad inserire una traccia già presente per il disco corrente. Se il problema persiste contattaci a vinylvault@gmail.com'];
        }
        mysqli_stmt_close($stmt_link);
    }
    mysqli_commit($connection->get_connection());
    return ['success' => true];
}