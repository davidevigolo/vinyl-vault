<?php

session_start();

$action = $_POST['action'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$disk_id = $_POST['disk_id'] ?? null;
$edition_name = $_POST['edition_name'] ?? null;

function remove_item_from_wishlist($user_id, $disk_id, $edition_name) {
    include_once '../classes/DbConnection.php';
    $connection = DbConnection::get_instance();
    $query = "DELETE FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $disk_id, $edition_name);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function edit_item_in_wishlist($user_id, $disk_id, $edition_name) {
    include once '../classes/DbConnection.php';
    $connection = DbConnection::get_instance();
    $priority_level = $_POST['priority_level'] ?? 1;
    $query = "UPDATE wishlist SET priority_level = ? WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    mysqli_stmt_bind_param($stmt, 'iiis', $priority_level, $user_id, $disk_id, $edition_name);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

if($action === 'remove' && $user_id && $disk_id && $edition_name) {
    remove_item_from_wishlist($user_id, $disk_id, $edition_name);
}   

if(action === 'edit' && $user_id && $disk_id && $edition_name) {
    edit_item_in_wishlist($user_id, $disk_id, $edition_name);
}
header('Location: ../../wishlist.php?edit=true');
