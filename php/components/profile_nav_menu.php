<?php
function profile_nav_menu(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    ob_start();
    if($isLoggedIn){
        echo Template::render('static/layout/profile_nav_menu_logged.html', []);
    } else {
        echo Template::render('static/layout/profile_nav_menu_guest.html', []);
    }
    return ob_get_clean();
}
?>