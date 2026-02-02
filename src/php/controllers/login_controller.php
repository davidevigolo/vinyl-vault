<?php

function login($req) {
    $errors = [];

    $email = trim($req['email']) ?? '';
    $password = $req['password'] ?? '';

    if (empty($email)) {
        $errors['email'] = 'L\'<span lang="en">email</span> è obbligatoria';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato <span lang="en">email</span> non valido';
    }
    if (empty($password)) {
        $errors['password'] = 'La <span lang="en">password</span> è obbligatoria';
    }
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }

    require_once 'php/classes/DbConnection.php';
    $conn = DbConnection::get_instance()->get_connection();

    $query = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['pw_hash'])) {
            assert(session_regenerate_id(true));

            $_SESSION['user_id'] = $row['id'];

            // populate session with the remaining data
            unset($row['id']);
            unset($row['pw_hash']);
            $_SESSION = array_merge($_SESSION, $row);

            return ['success' => true];
        }
    }

    $errors['auth'] = 'Login fallito: <span lang="en">email</span> o <span lang="en">password</span> non corretti';
    return ['success' => false, 'errors' => $errors];
}
