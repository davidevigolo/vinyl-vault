<?php
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$disk = $_POST['disk'] ?? null;
$edition = $_POST['edition'] ?? null;
$titles = $_POST['title'] ?? [];
$durations = $_POST['duration'] ?? [];

$titles = array_filter($titles, fn($value) => trim($value) !== '');
$durations = array_filter($durations, fn($value) => trim($value) !== '');

function add_tracks($disk, $edition, $titles, $durations)
{
    if (!$disk || !$edition || empty($titles) || !is_array($titles) || empty($durations) || !is_array($durations) || count($titles) !== count($durations)) {
        return false;
    }

    $count = count($titles);
    for ($i = 0; $i < $count; $i++) {
        $track_name = trim($titles[$i]);
        $duration = trim($durations[$i]);
        if (empty($track_name)) {
            return false;
        }
        $regex = "/^[a-zA-Z0-9àèéìòùÀÈÉÌÒÙ\s]{1,200}$/u";
        if (preg_match($regex, $track_name) !== 1) {
            return false;
        }
        if ($duration < 0 || $duration > 32767) { //limit of SMALLINT in database
            return false;
        }
    }

    $connection = DbConnection::get_instance();
    $query = "INSERT INTO track (title, duration_seconds) VALUES (?, ?);";
    $link_query = "INSERT INTO edition_track_part_of (disk_id, edition_name, track_id, track_number) VALUES (?, ?, ?, ?);";
    mysqli_begin_transaction($connection->get_connection());

    foreach ($titles as $index => $track_name) {
        $track_name = trim($track_name);
        $duration = trim($durations[$index]);
        $track_number = $index + 1;
        $stmt = mysqli_prepare($connection->get_connection(), $query);
        if (!$stmt) {
            mysqli_rollback($connection->get_connection());
            return false;
        }

        $success = mysqli_stmt_bind_param($stmt, 'si', $track_name, $duration);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return false;
        }
        $success = mysqli_stmt_execute($stmt);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return false;
        }
        mysqli_stmt_close($stmt);
        $track_id = mysqli_insert_id($connection->get_connection());
        $stmt_link = mysqli_prepare($connection->get_connection(), $link_query);
        if (!$stmt_link) {
            mysqli_rollback($connection->get_connection());
            return false;
        }
        $success = mysqli_stmt_bind_param($stmt_link, 'issi', $disk, $edition, $track_id, $track_number);
        if (!$success) {
            mysqli_rollback($connection->get_connection());
            return false;
        }
        $success = mysqli_stmt_execute($stmt_link);
        if (!$success) {
            error_log("Failed to link track to edition: " . mysqli_error($connection->get_connection()));
            mysqli_rollback($connection->get_connection());
            return false;
        }
        mysqli_stmt_close($stmt_link);
    }
    mysqli_commit($connection->get_connection());
    return true;
}

$success = add_tracks($disk, $edition, $titles, $durations);
header('Location: ../pages/add_tracks.php?result=' . ($success ? 'success' : 'fail'));
exit();
?>