<?php

function register($req) {
    $first_name = trim($req['first-name'] ?? '');
    $last_name = trim($req['last-name'] ?? '');
    $email = trim($req['email'] ?? '');
    $username = trim($req['username'] ?? '');
    $password = $req['password'] ?? '';
    $password_confirm = $req['password-confirm'] ?? '';

    $fields = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username
    ];

    $errors = [];
    $fields_error = 'Registrazione fallita; segui le indicazioni relative ai campi e riprova';
    $internal_error = 'Registrazione fallita; il nostro sistema ha riscontrato un errore, riprova tra 5 minuti, e se il problema persiste scrivici a <a href="mailto:help@vinylvault.it">help@vinylvault.it</a>';

    if (empty($first_name)) {
        $errors['first_name'] = 'Il nome è obbligatorio';
    } elseif (preg_match('/[0-9]/', $first_name)) {
        $errors['first_name'] = 'Il nome non può contenere numeri';
    }
    if (empty($last_name)) {
        $errors['last_name'] = 'Il cognome è obbligatorio';
    } elseif (preg_match('/[0-9]/', $last_name)) {
        $errors['last_name'] = 'Il cognome non può contenere numeri';
    }
    if (empty($username)) {
        $errors['username'] = 'Lo <span lang="en">username</span> è obbligatorio';
    }

    require_once 'php/classes/DbConnection.php';
    $conn = DbConnection::get_instance()->get_connection();

    if (empty($email)) {
        $errors['email'] = 'L\'<span lang="en">email</span> è obbligatoria';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato <span lang="en">email</span> non valido';
    } elseif (check_user_exists($conn, 'email', $email)) {
        $errors['email'] = 'Esiste già un utente con questa <span lang="en">email</span>';
    }

    if (!empty($username) && !isset($errors['username'])) {
        if (check_user_exists($conn, 'username', $username)) {
            $errors['username'] = 'Esiste già un utente con questo <span lang="en">username</span>';
        }
    }

    $password_check = validate_password_strength($password);
    if ($password_check !== true) {
        $errors['password'] = $password_check;
    }
    if ($password !== $password_confirm) {
        $errors['password_confirm'] = 'Le <span lang="en">password</span> non corrispondono';
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => array_merge($errors, ['registration' => $fields_error]), 'fields' => $fields];
    }

    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (first_name, last_name, email, username, pw_hash, is_admin) VALUES (?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return ['success' => false, 'errors' => ['registration' => $internal_error], 'fields' => $fields];
    }
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $username, $pw_hash);

    if ($stmt->execute()) {
        $new_user_id = $stmt->insert_id;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = 0;

        return ['success' => true];
    } else {
        return ['success' => false, 'errors' => ['registration' => $internal_error], 'fields' => $fields];
    }
}

/**
 * Helper to check if a value already exists in the users table
 */
function check_user_exists($conn, $column, $value) {
    // Whitelist allowed columns to prevent SQL injection in dynamic column name
    if (!in_array($column, ['email', 'username'])) {
        return false;
    }

    $query = "SELECT id FROM users WHERE $column = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();

    return $exists;
}

function validate_password_strength($password) {
    if (strlen($password) < 12) {
        return 'La <span lang="en">password</span> deve essere di almeno 12 caratteri';
    }
    if (preg_match_all('/[0-9]/', $password) < 2) {
        return 'La <span lang="en">password</span> deve contenere almeno 2 numeri';
    }
    if (preg_match_all('/[^a-zA-Z0-9]/', $password) < 2) {
        return 'La <span lang="en">password</span> deve contenere almeno 2 caratteri speciali';
    }
    return true;
}