<?php
function profile_nav_menu(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    ob_start();
    if($isLoggedIn){
        echo "<nav id='user-actions' aria-label='Menù di navigazione del profilo utente'><ul>
                <li><a href='profile.php' class=\"btn-primary\">Il mio profilo</a></li>
                <li><a href='logout.php' class=\"btn-primary\">Logout</a></li>
            </ul></nav>";
    } else {
        echo "<nav id='user-actions' aria-label='Menù di navigazione del profilo utente'><ul>
                <li><a href='login.php' class=\"btn-primary\">Login</a></li>
                <li><a href='register.php' class=\"btn-primary\">Registrati</a></li>
            </ul></nav>";
    }
    return ob_get_clean();
}
?>