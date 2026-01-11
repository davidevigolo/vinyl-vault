<?php

session_start();

$user_id = $_SESSION['user_id'] ?? null;
$disk_id = $_POST['disk_id'] ?? null;
$edition_name = $_POST['edition_name'] ?? null;

if ($user_id && $disk_id && $edition_name) {
    include_once '../classes/DbConnection.php';
    $connection = DbConnection::get_instance();
    $query = "DELETE FROM wishlist WHERE user_id = ? AND disk_id = ? AND edition_name = ?;";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $disk_id, $edition_name);
    if (mysqli_stmt_execute($stmt)) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(400);
}

header('Location: ../../wishlist.php?edit=true');
