<?php

function footer() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ob_start();
    echo Template::render('static/layout/footer.html', array_merge(footer_site_nav_menu(), [
        'profile_nav_menu' => footer_profile_nav_menu(),
    ]));
    return ob_get_clean();
}

function footer_profile_nav_menu() {
    $is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    if ($is_logged_in) {
        return Template::render('static/layout/profile_nav_menu_logged.html', footer_logged_profile_nav_links());
    }
    return Template::render('static/layout/profile_nav_menu_guest.html', footer_guest_profile_nav_links());
}

function footer_logged_profile_nav_links() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'profile' => $currentPage == 'profile.php' ? '<span class="current-page">Profilo</span>' : '<a href="logout.php">Profilo</a>',
        'logout' => '<a href="logout.php">Logout</a>'
    ];
}

function footer_guest_profile_nav_links() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'login' => $currentPage == 'login.php' ? '<li>Accedi</li>' : '<li><a href="login.php">Accedi</a></li>',
        'register' => $currentPage == 'register.php' ? '<li>Registrati</li>' : '<li><a href="register.php">Registrati</a></li>',
    ];
}

function footer_site_nav_menu() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'home' => $currentPage == 'index.php' || $currentPage == '' ? '<span class="current-page" lang="en">Home</span>' : '<a href="index.php"><span lang="en">Home</span></a>',
        'explore' => $currentPage == 'esplora.php' ? '<span class="current-page">Esplora</span>' : '<a href="esplora.php">Esplora</a>',
        'catalogue' => $currentPage == 'catalogo.php' ? '<span class="current-page">Catalogo</span>' : '<a href="catalogo.php">Catalogo</a>'
    ];
}
