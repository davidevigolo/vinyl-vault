<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'php/classes/resources.php';
check_user_logged_in();

require_once 'php/components/header.php';
require_once 'php/components/footer.php';

$errors = [];
$fields = [];
$success_message = '';

// Load current user data
$fields = [
    'first_name' => $_SESSION['first_name'] ?? '',
    'last_name' => $_SESSION['last_name'] ?? '',
    'username' => $_SESSION['username'] ?? '',
    'email' => $_SESSION['email'] ?? '',
    'bio' => $_SESSION['bio'] ?? '',
    'propic_path' => $_SESSION['propic_path'] ?? 'assets/images/default-avatar.png',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'php/controllers/edit_profile_controller.php';

    $form_type = $_POST['form-type'] ?? 'personal-info';

    if ($form_type === 'profile-picture') {
        $result = handle_profile_picture($_POST, $_FILES);
    } elseif ($form_type === 'password') {
        $result = update_password($_POST);
    } else {
        $result = update_profile($_POST);
    }

    if ($result['success']) {
        // Reload user data from session after update
        $fields = [
            'first_name' => $_SESSION['first_name'],
            'last_name' => $_SESSION['last_name'],
            'username' => $_SESSION['username'],
            'email' => $_SESSION['email'],
            'bio' => $_SESSION['bio'] ?? '',
            'propic_path' => $_SESSION['propic_path'] ?? 'assets/images/default-avatar.png'
        ];
        $success_message = $result['message'] ?? '';
    } else {
        $errors = $result['errors'];
        // Preserve submitted values for personal info form
        if ($form_type === 'personal-info' && isset($result['fields'])) {
            $fields = array_merge($fields, $result['fields']);
        }
    }
}

echo Template::render(
    'static/edit_profile.html',
    [
        'head' => Template::render('static/layout/head.html', []),
        'header' => _header(),
        'footer' => footer(),
        'first-name-value' => htmlspecialchars($fields['first_name']),
        'last-name-value' => htmlspecialchars($fields['last_name']),
        'username-value' => htmlspecialchars($fields['username']),
        'email-value' => htmlspecialchars($fields['email']),
        'bio-value' => htmlspecialchars($fields['bio']),
        'propic_path' => htmlspecialchars($fields['propic_path']),
        'first-name-error' => error_container('first-name-error-container', $errors['first_name'] ?? ''),
        'last-name-error' => error_container('last-name-error-container', $errors['last_name'] ?? ''),
        'username-error' => error_container('username-error-container', $errors['username'] ?? ''),
        'email-error' => error_container('email-error-container', $errors['email'] ?? ''),
        'bio-error' => error_container('bio-error-container', $errors['bio'] ?? ''),
        'password-error' => error_container('password-error-container', $errors['password'] ?? ''),
        'password-confirm-error' => error_container('password-confirm-error-container', $errors['password_confirm'] ?? ''),
        'propic-error' => error_container('propic-error-container', $errors['propic'] ?? ''),
        'propic-success' => success_container('propic-success-container', $success_message, 'profile-picture'),
        'personal-info-error' => error_container('personal-info-error-container', $errors['personal_info'] ?? ''),
        'personal-info-success' => success_container('personal-info-success-container', $success_message, 'personal-info'),
        'password-form-error' => error_container('password-form-error-container', $errors['password_form'] ?? ''),
        'password-success' => success_container('password-success-container', $success_message, 'password'),
        'remove-propic-disabled' => ($_SESSION['propic_path'] ?? '') === 'assets/images/default-avatar.png' ? 'disabled="disabled"' : '',
    ]
);

function error_container($id, $err_msg) {
    if (!$err_msg) {
        return '';
    }
    return "<p id=\"$id\" aria-live=\"assertive\" class=\"error-message\">$err_msg</p>";
}

function success_container($id, $success_msg, $form_type) {
    if (!$success_msg) {
        return '';
    }
    // Only show success message if it matches the form type
    $form_type_map = [
        'profile-picture' => ['Foto profilo aggiornata'],
        'personal-info' => ['Informazioni personali'],
        'password' => ['Password']
    ];

    if (isset($form_type_map[$form_type])) {
        foreach ($form_type_map[$form_type] as $keyword) {
            if (strpos($success_msg, $keyword) !== false) {
                return "<p id=\"$id\" aria-live=\"polite\" class=\"success-message\">$success_msg</p>";
            }
        }
    }
    return '';
}
