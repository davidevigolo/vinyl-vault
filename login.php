<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "php/classes/resources.php";
require_once "php/components/header.php";
require_once "php/components/footer.php";

$errors = [];

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'php/controllers/login_controller.php';
    $result = login($_POST);

    if ($result['success']) {
        header('Location: profile.php');
        exit();
    }

    $errors = $result['errors'];
}

echo Template::render(
    'static/login.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'footer' => footer(),
        'email-error' => error_container('email-error-container', $errors['email'] ?? null),
        'password-error' => error_container('password-error-container', $errors['password'] ?? null),
        'auth-error' => error_container('auth-error-container', $errors['auth'] ?? null),
    ]
);

function error_container($id, $err_msg) {
    if (!$err_msg) {
        return '';
    }
    return '<p id="' . $id . '" aria-live="assertive" class="error-message">' . $err_msg . '</p>';
}