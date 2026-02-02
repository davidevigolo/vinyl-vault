<?php
function _header() { /* _header instead of header since header() is a PHP built-in function */
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $is_logged_in = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    ob_start();

    $page_links = header_site_nav_menu();
    $search_toggle = '<button class="search-toggle" aria-expanded="false" aria-controls="header-search-form"
                    aria-label="Apri ricerca nel catalogo">
                    <img class="search-icon" src="assets/images/search-light.webp" alt="" />
                </button>';

    echo Template::render('static/layout/header.html', array_merge($page_links, [
        'profile_nav_menu' => header_profile_nav_menu($is_logged_in),
        'search_toggle' => basename($_SERVER["PHP_SELF"]) != 'catalog.php' ? $search_toggle : '',
    ]));
    return ob_get_clean();
}

function header_profile_nav_menu($is_logged_in) {
    if ($is_logged_in) {
        return Template::render('static/layout/profile_nav_menu_logged.html', header_nav_menu_logged_links());
    }
    return Template::render('static/layout/profile_nav_menu_guest.html', header_nav_menu_guest_links());
}

function header_nav_menu_logged_links() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'profile' => $currentPage == 'profile.php' ? '<li><span class="btn-primary disabled" aria-current="page">Profilo</span></li>' : '<li><a href="profile.php" class="btn-primary">Profilo</a></li>',
        'logout' => '<li><a href="logout.php" class="btn-primary">Logout</a></li>',
        'wishlist' => '',
        'collection' => '',
    ];
}

function header_nav_menu_guest_links() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'login' => $currentPage == 'login.php' ? '' : '<li><a href="login.php" class="btn-primary">Accedi</a></li>',
        'register' => $currentPage == 'register.php' ? '' : '<li><a href="register.php" class="btn-primary">Registrati</a></li>',
    ];
}

function header_site_nav_menu() {
    $currentPage = basename($_SERVER["PHP_SELF"]);
    return [
        'home' => $currentPage == 'index.php' || $currentPage == '' ? '<span class="current-page" aria-current="page" lang="en">Home</span>' : '<a href="index.php"><span lang="en">Home</span></a>',
        'explore' => $currentPage == 'explore.php' ? '<span class="current-page" aria-current="page">Esplora</span>' : '<a href="explore.php">Esplora</a>',
        'catalogue' => $currentPage == 'catalog.php' ? '<span class="current-page" aria-current="page">Catalogo</span>' : '<a href="catalog.php">Catalogo</a>'
    ];
}
