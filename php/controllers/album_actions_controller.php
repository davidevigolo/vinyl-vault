<?php
include_once '../classes/DbConnection.php';
include_once '../classes/utils.php';

check_user_logged_in();

function add_to_collection($disk_id,$edition_id,$user_id){
    $connection = DbConnection::get_instance();

    // Remove from wishlist if present
    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?";
    $delete_stmt = mysqli_prepare($connection->get_connection(), $delete_query);
    if ($delete_stmt) {
        mysqli_stmt_bind_param($delete_stmt, "iis", $user_id, $disk_id, $edition_id);
        mysqli_stmt_execute($delete_stmt);
        mysqli_stmt_close($delete_stmt);
    } else {
        error_log("Prepare failed (wishlist delete): " . mysqli_error($connection->get_connection()));
    }

    // Add to collection
    $query = "INSERT INTO ownership (user_id, disk_id, edition_name) VALUES (?, ?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $disk_id, $edition_id);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        return false;
    }
    mysqli_stmt_close($stmt);
    return true;
}

function add_to_wishlist($disk_id,$edition_id,$user_id){
    $connection = DbConnection::get_instance();
    $query = "INSERT INTO wishlist (user_id, disk_id, edition_name) VALUES (?, ?, ?);";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($connection->get_connection()));
        return false;
    }
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $disk_id, $edition_id);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        return false;
    }
    mysqli_stmt_close($stmt);
    return true;
}

$disk_id = $_POST['disk_id'] ?? null;
$edition_name = $_POST['edition_name'] ?? null;
$action = $_POST['action'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if($action === 'add_to_collection'){
    $result = add_to_collection($disk_id,$edition_name,$user_id);
    if($result){
        $_SESSION['album_actions_result']['message'] = "Album aggiunto con successo alla tua collezione";
        $_SESSION['album_actions_result']['success'] = true;
    }else{
        $_SESSION['album_actions_result']['message'] = "Non siamo riusciti ad aggiungere l'album alla tua collezione, controlla che non sia già presente.";
        $_SESSION['album_actions_result']['success'] = false;
    }
} elseif ($action ==='add_to_wishlist'){
    $result = add_to_wishlist($disk_id,$edition_name,$user_id);
    if($result){
        $_SESSION['album_actions_result']['message'] = "Album aggiunto con successo alla tua lista dei desideri";
        $_SESSION['album_actions_result']['success'] = true;
    }else{
        $_SESSION['album_actions_result']['message'] = "Non siamo riusciti ad aggiungere l'album alla tua lista dei desideri, controlla che non sia già presente.";
        $_SESSION['album_actions_result']['success'] = false;
    }
}

header("Location: ../../album.php?id=" . urlencode($disk_id) . "&edition=" . urlencode($edition_name));
exit();