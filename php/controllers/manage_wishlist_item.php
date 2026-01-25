<?php

session_start();
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

function edit_multiple_items_in_collection($disk_ids, $edition_names, $priority_levels, $items_to_delete, $user_id): array
{
    if (!is_array($disk_ids) || !is_array($edition_names) || !is_array($priority_levels)) {
        return ['success' => false, 'error' => 'Alcuni dati devono ancora essere compilati'];
    }

    $count = count($disk_ids);
    if ($count !== count($edition_names) || $count !== count($priority_levels)) {
        return ['success' => false, 'error' => 'Alcuni dati devono ancora essere compilati'];
    }

    if ($count === 0) {
        return ['success' => true]; // No items to update is considered success
    }

    $connection = DbConnection::get_instance();
    $update_query = "UPDATE wishlist SET priority_level = ? WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";

    $update_stmt = mysqli_prepare($connection->get_connection(), $update_query);
    $delete_stmt = mysqli_prepare($connection->get_connection(), $delete_query);

    if (!$update_stmt || !$delete_stmt) {
        return ['success' => false, 'error' => 'I dati che hai inserito non sono validi, prova ad aggiornare la pagina e riprovare'];
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
                return ['success' => false, 'error' => 'I livelli di priorità devono essere numeri interi compresi tra 0 e 100'];
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
    return ['success' => $success, 'error' => $success ? '' : 'Si è verificato un errore durante l\'aggiornamento della tua wishlist. Probabilmente i dati che hai inserito non sono validi, prova ad aggiornare la pagina e riprovare'];
}

$user_id = $_SESSION['user_id'] ?? null;
$disk_ids = $_POST['disk_id'] ?? [];
$edition_names = $_POST['edition_name'] ?? [];
$priority_levels = $_POST['priority_level'] ?? [];
$items_to_delete = $_POST['items_to_delete'] ?? [];
$result = edit_multiple_items_in_collection($disk_ids, $edition_names, $priority_levels, $items_to_delete, $user_id);
$_SESSION['manage_wishlist_result'] = $result;
// Build associative arrays for items_to_delete and priorities
$items_to_delete_assoc = [];
$priorities_assoc = [];
foreach ($disk_ids as $idx => $d_id) {
    $key = $d_id . '_' . $edition_names[$idx];
    $items_to_delete_assoc[$key] = in_array($key, $items_to_delete);
    $priorities_assoc[$key] = intval($priority_levels[$idx]);
}
$_SESSION['manage_wishlist_result']['items_to_delete'] = $items_to_delete_assoc;
$_SESSION['manage_wishlist_result']['priority_levels'] = $priorities_assoc;
header('Location:' . ($_SESSION['manage_wishlist_result']['success'] ? '../../wishlist.php' : '../../wishlist.php?edit=true'));
exit();
