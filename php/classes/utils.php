<?php
function get_logged_user(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_id'])) {
        return [
            'user_id' => $_SESSION['user_id'],
        ];
    }
    return null;
}

function check_user_logged_in(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION['user_id'])) {
        header("Location: /login.php");
        http_response_code(403);
        exit();
    }
}