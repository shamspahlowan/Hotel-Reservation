<?php
session_start();
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);

    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';
    $errors = [];

    // Validation (same as JS)
    $parts = explode('@', $email);
    if ($email === '' || count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
        $errors[] = "Invalid email format.";
    } else {
        $domainParts = explode('.', $parts[1]);
        if (count($domainParts) < 2 || $domainParts[0] === '' || $domainParts[1] === '') {
            $errors[] = "Email must be in the valid format (e.g., example@domain.com).";
        }
    }
    if ($password === '') {
        $errors[] = "Password cannot be empty.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!empty($errors)) {
        echo implode("<br>", $errors);
        exit;
    }

    // Admin shortcut (optional)
    if ($email === "admin@admin.com" && $password === "123456") {
        $_SESSION["isAdmin"] = "true";
        echo "admin";
        exit;
    }

    // User login
    $user = login($email, $password);
    if ($user) {
        $_SESSION["status"] = "true";
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["username"] = $user['username'];
        $_SESSION["email"] = $user['email'];
        echo "success";
    } else {
        echo "Invalid email or password.";
    }
    exit;
}
?>