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
        'profile' => $currentPage == 'profile.php' ? '<li><span class="current-page" aria-current="page">Profilo</span></li>' : '<li><a href="profile.php">Profilo</a></li>',
        'logout' => '<li><a href="logout.php">Logout</a></li>',
        'wishlist' => $currentPage == 'wishlist.php' ? '<li><span class="current-page" aria-current="page">Lista desideri</span></li>' : '<li><a href="wishlist.php">Lista desideri</a></li>',
        'collection' => $currentPage == 'collection.php' ? '<li><span class="current-page" aria-current="page">Collezione</span></li>' : '<li><a href="collection.php">Collezione</a></li>',
    ];
}

function footer_guest_profile_nav_links() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'login' => $currentPage == 'login.php' ? '<li aria-current="page">Accedi</li>' : '<li><a href="login.php">Accedi</a></li>',
        'register' => $currentPage == 'register.php' ? '<li aria-current="page">Registrati</li>' : '<li><a href="register.php">Registrati</a></li>',
    ];
}

function footer_site_nav_menu() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'home' => $currentPage == 'index.php' || $currentPage == '' ? '<span class="current-page" lang="en" aria-current="page">Home</span>' : '<a href="index.php"><span lang="en">Home</span></a>',
        'explore' => $currentPage == 'explore.php' ? '<span class="current-page" aria-current="page">Esplora</span>' : '<a href="explore.php">Esplora</a>',
        'catalogue' => $currentPage == 'catalog.php' ? '<span class="current-page" aria-current="page">Catalogo</span>' : '<a href="catalog.php">Catalogo</a>',
        'top_artists' => $currentPage == 'top_artists.php' ? '<span class="current-page" aria-current="page">Classifica Artisti</span>' : '<a href="top_artists.php">Classifica Artisti</a>',
        'top_vinyls' => $currentPage == 'top_vinyls.php' ? '<span class="current-page" aria-current="page">Classifica Vinili</span>' : '<a href="top_vinyls.php">Classifica Vinili</a>'
    ];
}
