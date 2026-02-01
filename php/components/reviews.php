<?php
require_once 'php/classes/Template.php';
require_once 'php/classes/DbConnection.php';


function reviews($disk_id, $edition_name): string {
    $connection = DbConnection::get_instance();
    $query = "SELECT r.rating, r.content, u.username 
              FROM review r 
              JOIN users u ON r.user_id = u.id 
              WHERE r.disk_id = ? AND r.edition_name = ?
              ORDER BY r.publish_date DESC";
    $stmt = $connection->get_connection()->prepare($query);
    $stmt->bind_param("is", $disk_id, $edition_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        error_log(mysqli_error($connection->get_connection()));
        return '';
    }
    $reviews_html = '';
    if(mysqli_num_rows($result) === 0){
        return '<p>Non ci sono ancora recensioni per questa edizione</p>';
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews_html .= Template::render('static/layout/album/review_item.html', [
            'username' => htmlspecialchars($row['username']),
            'rating' => htmlspecialchars($row['rating']),
            'content' => nl2br(htmlspecialchars($row['content']))
        ]);
    }
    mysqli_free_result($result);
    return $reviews_html;
}