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
    $priority_levels = $_POST['priority_level'] ?? [];
    $items_to_delete = $_POST['items_to_delete'] ?? [];

    if (!is_array($disk_ids) || !is_array($edition_names) || !is_array($priority_levels)) {
        return false;
    }

    $count = count($disk_ids);
    if ($count !== count($edition_names) || $count !== count($priority_levels)) {
        return false;
    }

    if ($count === 0) {
        return true; // No items to update is considered success
    }

    $connection = DbConnection::get_instance();
    $update_query = "UPDATE wishlist SET priority_level = ? WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";

    $update_stmt = mysqli_prepare($connection->get_connection(), $update_query);
    $delete_stmt = mysqli_prepare($connection->get_connection(), $delete_query);

    if (!$update_stmt || !$delete_stmt) {
        return false;
    }
    $success = true;
    for ($i = 0; $i < $count; $i++) {
        $item_key = $disk_ids[$i] . '_' . $edition_names[$i];
        
        if (in_array($item_key, $items_to_delete)) {
            $disk_id = intval($disk_ids[$i]);
            mysqli_stmt_bind_param($delete_stmt, 'iis', $user_id, $disk_id, $edition_names[$i]);
            if (!mysqli_stmt_execute($delete_stmt)) {
                $success = false;
            }
        } else {
            $priority_level = intval($priority_levels[$i]);
            $disk_id = intval($disk_ids[$i]);
            $edition_name = $edition_names[$i];

            // Validate priority level range
            if ($priority_level < 0 || $priority_level > 100) {
                $success = false;
            } else {
                mysqli_stmt_bind_param($update_stmt, 'iiis', $priority_level, $user_id, $disk_id, $edition_name);
                if (!mysqli_stmt_execute($update_stmt)) {
                    $success = false;
                }
            }
        }
    }

    mysqli_stmt_close($update_stmt);
    mysqli_stmt_close($delete_stmt);
    return $success;
}

$result = -1;
if ($action === 'edit_multiple' && $user_id) {
    $op_result = edit_multiple_items_in_collection($user_id);
    $result = $op_result ? 0 : 1;
}

switch ($result) {
    case 0:
        $_SESSION['wishlist_action_status'] = 'success';
        break;
    case 1:
        $_SESSION['wishlist_action_status'] = 'error';
        break;
    default:
        $_SESSION['wishlist_action_status'] = 'invalid';
        break;
}
header('Location: ../../wishlist.php');
exit();
