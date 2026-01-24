<?php

function login($req) {
    $errors = [];

    $email = trim($req['email']) ?? '';
    $password = $req['password'] ?? '';

    if (empty($email)) {
        $errors['email'] = 'L\'email è obbligatoria';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato email non valido';
    }
    if (empty($password)) {
        $errors['password'] = 'La password è obbligatoria';
    }
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    require_once 'php/classes/DbConnection.php';
    $conn = DbConnection::get_instance()->get_connection();

    $query = "SELECT id, first_name, pw_hash, is_admin FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['pw_hash'])) {
            assert(session_regenerate_id(true));
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['first_name'] = $row['first_name'];
            $_SESSION['is_admin'] = $row['is_admin'];
            return ['success' => true];
        }
    }

    $errors['auth'] = "Email o password non corretti";
    return ['success' => false, 'errors' => $errors];
}
