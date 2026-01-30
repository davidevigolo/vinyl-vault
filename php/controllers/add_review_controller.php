<?php

require_once '../classes/DbConnection.php';
require_once '../classes/Template.php';
require_once '../classes/utils.php';

check_user_logged_in();

function add_review($user_id,$disk_id, $edition_name, $rating, $review_text): array
{
    if (!$rating || !$review_text) {
        return ['success' => false, 'error' => 'Uno o più campi devono ancora essere compilati'];
    }
    $review_text = trim($review_text);
    if (strlen($review_text) > 300) {
        return ['success' => false, 'error' => 'Il testo non deve superare i 300 caratteri', 'fields_to_reset' => ['review_text']];
    }
    if ($rating < 1 || $rating > 5) {
        return ['success' => false, 'error' => 'Valutazione non valida', 'fields_to_reset' => ['rating']];
    }

    $connection = DbConnection::get_instance();
    $query = "INSERT INTO review (user_id, disk_id, edition_name, rating, content, publish_date) VALUES (?, ?, ?, ?, ?, NOW());";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log("Error preparing statement: " . mysqli_error($connection->get_connection()));
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della recensione. Probabilmente hai già recensito questo album.'];
    }
    mysqli_stmt_bind_param($stmt, 'iisis', $user_id, $disk_id, $edition_name, $rating, $review_text);
    $success = mysqli_stmt_execute($stmt);

    if (!$success) {
        error_log("Error inserting review: " . mysqli_stmt_error($stmt));
        return ['success' => false, 'error' => 'Abbiamo riscontrato un errore durante l\'inserimento della recensione. Probabilmente hai già recensito questo album.'];
    }

    mysqli_stmt_close($stmt);
    return ['success' => true];
}

$user_id = $_SESSION['user_id'];
$disk_id = isset($_POST['disk_id']) ? intval($_POST['disk_id']) : null;
$edition_name = isset($_POST['edition_name']) ? trim($_POST['edition_name']) : null;
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : null;
$review_text = isset($_POST['review_text']) ? trim($_POST['review_text']) : null;

$result = add_review($user_id, $disk_id, $edition_name, $rating, $review_text);
$_SESSION['add_review_result'] = $result;
$_SESSION['add_review_result']['rating'] = $rating;
$_SESSION['add_review_result']['review_text'] = $review_text;
header('Location: ../../album.php?id=' . $disk_id . '&edition=' . urlencode($edition_name));
exit();