<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

session_unset();
assert(session_regenerate_id(true));

header('Location: index.php');