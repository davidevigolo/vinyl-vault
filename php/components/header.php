<?php
function _header(){ /* _header instead of header since header() is a PHP built-in function */
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    ob_start();
    include_once 'php/components/profile_nav_menu.php';
    echo Template::render('static/layout/header.html',[
        'profile_nav_menu' => profile_nav_menu()
    ]);
    return ob_get_clean();
}