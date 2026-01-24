<?php

session_start();
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

$action = $_POST['action'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$disk_id = $_POST['disk_id'] ?? null;
$edition_name = $_POST['edition_name'] ?? null;

function edit_multiple_items_in_collection($user_id)
{
    $disk_ids = $_POST['disk_id'] ?? [];
    $edition_names = $_POST['edition_name'] ?? [];
    $items_to_delete = $_POST['items_to_delete'] ?? [];
    $rating = $_POST['rating'] ?? [];

    if (!is_array($disk_ids) || !is_array($edition_names)) {
        return false;
    }

    $count = count($disk_ids);
    if ($count !== count($edition_names)) {
        return false;
    }

    if ($count === 0) {
        return true; // No items to update is considered success
    }

    foreach($rating as $rate) {
        if (!is_numeric($rate) || intval($rate) < 0 || intval($rate) > 5) {
            return false;
        }
    }

    $connection = DbConnection::get_instance();
    mysqli_begin_transaction($connection->get_connection());
    $delete_query = "DELETE FROM ownership WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $update_rating_query = "UPDATE ownership SET rating = ? WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $update_stmt = mysqli_prepare($connection->get_connection(), $update_rating_query);
    $delete_stmt = mysqli_prepare($connection->get_connection(), $delete_query);

    if (!$delete_stmt || !$update_stmt) {
        error_log(mysqli_error($connection->get_connection()));
        mysqli_rollback($connection->get_connection());
        return false;
    }

    $success = true;
    for ($i = 0; $i < $count; $i++) {
        $item_key = $disk_ids[$i] . '_' . $edition_names[$i];
        
        if (in_array($item_key, $items_to_delete)) {
            $disk_id = intval($disk_ids[$i]);
            mysqli_stmt_bind_param($delete_stmt, 'iis', $user_id, $disk_id, $edition_names[$i]);
            if (!mysqli_stmt_execute($delete_stmt)) {
                error_log(mysqli_error($connection->get_connection()));
                mysqli_rollback($connection->get_connection());
                $success = false;
            }
        }
        else {
            $disk_id = intval($disk_ids[$i]);
            $personal_rating = intval($rating[$i]);
            mysqli_stmt_bind_param($update_stmt, 'iiis', $personal_rating, $user_id, $disk_id, $edition_names[$i]);
            if (!mysqli_stmt_execute($update_stmt)) {
                error_log(mysqli_error($connection->get_connection()));
                mysqli_rollback($connection->get_connection());
                $success = false;
            }
        }
    }
    mysqli_stmt_close($delete_stmt);
    mysqli_stmt_close($update_stmt);
    mysqli_commit($connection->get_connection());
    return $success;
}

$result = -1;
if ($action === 'edit_multiple' && $user_id) {
    $op_result = edit_multiple_items_in_collection($user_id);
    $result = $op_result ? 0 : 1;
}

switch ($result) {
    case 0:
        $_SESSION['collection_action_status'] = 'success';
        break;
    case 1:
        $_SESSION['collection_action_status'] = 'error';
        break;
    default:
        $_SESSION['collection_action_status'] = 'invalid';
        break;
}
header('Location: ../../collection.php');
exit();