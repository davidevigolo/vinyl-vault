<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "php/classes/resources.php";
require_once "php/components/header.php";
require_once "php/components/footer.php";

$errors = [];
$fields = [];

if (isset($_SESSION['user_id'])) {
    header('Location: profile.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'php/controllers/registration_controller.php';
    $result = register($_POST);

    if ($result['success']) {
        header('Location: profile.php');
        exit();
    }

    $errors = $result['errors'];
    $fields = $result['fields'];
}

echo Template::render(
    'static/register.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'footer' => footer(),
        'first-name-value' => $fields['first_name'] ?? '',
        'last-name-value' => $fields['last_name'] ?? '',
        'email-value' => $fields['email'] ?? '',
        'username-value' => $fields['username'] ?? '',
        'first-name-error' => error_container('first-name-error-container', $errors['first_name'] ?? ''),
        'last-name-error' => error_container('last-name-error-container', $errors['last_name'] ?? ''),
        'email-error' => error_container('email-error-container', $errors['email'] ?? ''),
        'username-error' => error_container('username-error-container', $errors['username'] ?? ''),
        'password-error' => error_container('password-error-container', $errors['password'] ?? ''),
        'password-confirm-error' => error_container('password-confirm-error-container', $errors['password_confirm'] ?? ''),
        'registration-error' => error_container('registration-error', $errors['registration'] ?? ''),
    ]
);

function error_container($id, $err_msg) {
    if (!$err_msg) {
        return '';
    }
    return "<p id=\"$id\" aria-live=\"assertive\" class=\"error-message\">$err_msg</p>";
}