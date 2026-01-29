<?php

require_once 'php/classes/DbConnection.php';

function update_profile($req) {
    $first_name = trim($req['first-name'] ?? '');
    $last_name = trim($req['last-name'] ?? '');
    $email = trim($req['email'] ?? '');
    $username = trim($req['username'] ?? '');
    $bio = trim($req['bio'] ?? '');

    $fields = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'username' => $username,
        'bio' => $bio
    ];

    $errors = [];
    $fields_error = 'Modifica fallita; segui le indicazioni relative ai campi e riprova';
    $internal_error = 'Modifica fallita; il nostro sistema ha riscontrato un errore, riprova tra 5 minuti, e se il problema persiste scrivici a <a href="mailto:help@vinylvault.it">help@vinylvault.it</a>';

    // Validate required fields
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

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'L\'<span lang="en">email</span> è obbligatoria';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato <span lang="en">email</span> non valido';
    }

    // Validate bio length
    if (strlen($bio) > 500) {
        $errors['bio'] = 'La bio non può superare i 500 caratteri';
    }

    $conn = DbConnection::get_instance()->get_connection();
    $user_id = intval($_SESSION['user_id']);

    // Check if email is taken by another user
    if (!empty($email) && !isset($errors['email'])) {
        $query = "SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['email'] = 'Esiste già un utente con questa <span lang="en">email</span>';
        }
        $stmt->close();
    }

    // Check if username is taken by another user
    if (!empty($username) && !isset($errors['username'])) {
        $query = "SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors['username'] = 'Questo <span lang="en">username</span> è già utilizzato da un altro utente';
        }
        $stmt->close();
    }

    if (!empty($errors)) {
        return ['success' => false, 'errors' => array_merge($errors, ['personal_info' => $fields_error]), 'fields' => $fields];
    }

    // Update database
    $query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, username = ?, bio = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return ['success' => false, 'errors' => ['personal_info' => $internal_error], 'fields' => $fields];
    }
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $username, $bio, $user_id);

    if ($stmt->execute()) {
        // Update session data
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['bio'] = $bio;

        return ['success' => true, 'message' => 'Informazioni personali modificate correttamente'];
    } else {
        return ['success' => false, 'errors' => ['personal_info' => $internal_error], 'fields' => $fields];
    }
}

function update_password($req) {
    $new_password = $req['new-password'] ?? '';
    $confirm_password = $req['confirm-password'] ?? '';

    $errors = [];
    $internal_error = 'Modifica fallita; il nostro sistema ha riscontrato un errore, riprova tra 5 minuti, e se il problema persiste scrivici a <a href="mailto:help@vinylvault.it">help@vinylvault.it</a>';

    // Validate password
    if (empty($new_password)) {
        $errors['password'] = 'Inserisci la nuova <span lang="en">password</span>';
    } else {
        $password_check = validate_password_strength($new_password);
        if ($password_check !== true) {
            $errors['password'] = $password_check;
        }
    }

    if ($new_password !== $confirm_password) {
        $errors['password_confirm'] = 'Le <span lang="en">password</span> non corrispondono';
    }

    if (!empty($errors)) {
        $error_msg = !empty($errors['password']) || !empty($errors['password_confirm'])
            ? 'Modifica fallita; segui le indicazioni relative ai campi e riprova'
            : '';
        return ['success' => false, 'errors' => array_merge($errors, ['password_form' => $error_msg])];
    }

    // Update database
    $conn = DbConnection::get_instance()->get_connection();
    $user_id = intval($_SESSION['user_id']);
    $pw_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET pw_hash = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return ['success' => false, 'errors' => ['password_form' => $internal_error]];
    }
    $stmt->bind_param("si", $pw_hash, $user_id);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => '<span lang="en">Password</span> aggiornata correttamente'];
    } else {
        return ['success' => false, 'errors' => ['password_form' => $internal_error]];
    }
}

function handle_profile_picture($req, $files) {
    $action = $req['action'] ?? 'upload';
    $internal_error = 'Operazione fallita; il nostro sistema ha riscontrato un errore, riprova tra 5 minuti, e se il problema persiste scrivici a <a href="mailto:help@vinylvault.it">help@vinylvault.it</a>';

    $user_id = intval($_SESSION['user_id']);
    $conn = DbConnection::get_instance()->get_connection();

    // Handle remove action
    if ($action === 'remove-propic') {
        $query = "UPDATE users SET propic_path = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $_SESSION['propic_path'] = 'assets/images/default-avatar.png';
            return ['success' => true, 'message' => 'Foto profilo rimossa con successo'];
        } else {
            return ['success' => false, 'errors' => ['propic' => $internal_error]];
        }
    }

    // Handle upload action
    if (!isset($files['profile-picture']) || $files['profile-picture']['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'errors' => ['propic' => 'Seleziona un\'immagine da caricare']];
    }

    $file = $files['profile-picture'];

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'errors' => ['propic' => 'Errore durante il caricamento del file']];
    }

    // Validate file size (1MB max)
    $max_size = 1 * 1024 * 1024; // 1MB in bytes
    if ($file['size'] > $max_size) {
        return ['success' => false, 'errors' => ['propic' => 'Il file supera la dimensione massima di 1<abbr title="Megabyte" lang="en">MB</abbr>']];
    }

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        return ['success' => false, 'errors' => ['propic' => 'Formato file non valido. Usa <abbr title="Joint Photographic Experts Group" lang="en">JPG</abbr> o <abbr title="Web Picture format" lang="en">WEBP</abbr>']];
    }

    // Generate unique filename
    $extension = match ($mime_type) {
        'image/jpeg' => 'jpg',
        'image/webp' => 'webp',
        default => 'jpg'
    };

    $upload_dir = 'assets/uploaded_images/profile_pictures/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $filename = 'user_' . $user_id . '_' . time() . '.' . $extension;
    $upload_path = $upload_dir . $filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        // Update database
        $query = "UPDATE users SET propic_path = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $upload_path, $user_id);

        if ($stmt->execute()) {
            $_SESSION['propic_path'] = $upload_path;
            return ['success' => true, 'message' => 'Foto profilo aggiornata con successo'];
        } else {
            // Clean up uploaded file if database update fails
            unlink($upload_path);
            return ['success' => false, 'errors' => ['propic' => $internal_error]];
        }
    } else {
        return ['success' => false, 'errors' => ['propic' => 'Errore durante il salvataggio del file']];
    }
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
