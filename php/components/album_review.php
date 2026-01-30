<?php
require_once 'php/classes/Template.php';
require_once 'php/classes/DbConnection.php';

function get_user_review($user_id, $disk_id, $edition_id){
    $connection = DbConnection::get_instance();
    $query = "SELECT rating, content FROM review WHERE user_id = ? AND disk_id = ? AND edition_name = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log(mysqli_error($connection->get_connection()));
        return null;
    }
    mysqli_stmt_bind_param($stmt, 'iii', $user_id, $disk_id, $edition_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return ['rating' => $row['rating'], 'review_text' => $row['content']];
    }
    return null;
}

function check_user_has_disk_in_collection($user_id, $disk_id, $edition_name): bool {
    $connection = DbConnection::get_instance();
    $query = "SELECT 1 FROM ownership WHERE user_id = ? AND disk_id = ? AND edition_name = ?";
    $stmt = mysqli_prepare($connection->get_connection(), $query);
    if (!$stmt) {
        error_log(mysqli_error($connection->get_connection()));
        return false;
    }
    mysqli_stmt_bind_param($stmt, 'iis', $user_id, $disk_id, $edition_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
}

function album_review($user_id,$disk_id,$edition_name): string{
    ob_start();
    if(!$user_id){
        return '<p>Effettua il <a href="login.php" lang="en">login</a> per lasciare una recensione.</p>';
    }
    $user_review = get_user_review($user_id, $disk_id, $edition_name);
    $radios = '';
    for ($i = 1; $i <= 5; $i++) {
        $checked = ($user_review && $user_review['rating'] == $i) ? 'checked' : ($i == 1 && !$user_review ? 'checked' : '');
        $radios .= "<input type=\"radio\" id=\"star{$i}\" name=\"rating\" value=\"{$i}\" {$checked} required><label for=\"star{$i}\">{$i} stelle</label>";
    }
    if ($user_review) {
        echo Template::render('static/layout/album/album_review.html', [
            'rating' => htmlspecialchars($user_review['rating'])
        ]);
        return ob_get_clean();
    }
    $user_has_disk = check_user_has_disk_in_collection($user_id, $disk_id, $edition_name);
    if (!$user_has_disk) {
        return '';
    }
    $rating = $_SESSION['add_review_result']['rating'] ?? null;
    $review_text = $_SESSION['add_review_result']['review_text'] ?? '';
    $errors = $_SESSION['add_review_result']['error'] ?? '';
    unset($_SESSION['add_review_result']);
    echo Template::render('static/layout/album/album_review_form.html', [
        'radio_buttons' => $radios,
        'text' => htmlspecialchars($review_text),
        'disk_id' => htmlspecialchars($disk_id),
        'edition_name' => htmlspecialchars($edition_name),
        'errors' => htmlspecialchars($errors)
    ]);
    return ob_get_clean();
}