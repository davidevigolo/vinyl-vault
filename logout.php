<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['user_id']);
unset($_SESSION['first_name']);
unset($_SESSION['is_admin']);

session_regenerate_id(true);

header('Location: index.php');