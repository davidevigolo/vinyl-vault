<?php

function footer(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    ob_start();
    include_once 'php/components/profile_nav_menu.php';
    echo Template::render('static/layout/footer.html',[
        'profile_nav_menu' => profile_nav_menu(),
        'site_nav_menu' => Template::render('static/layout/site_nav_menu.html', [])
    ]);
    return ob_get_clean();
}