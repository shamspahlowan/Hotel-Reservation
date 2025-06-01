<?php
session_start();
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if (!isset($_SESSION['status'])) {
    echo "Not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);
    $password = $data['password'] ?? '';

    if ($password === '') {
        echo "Password cannot be empty.";
        exit;
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
        exit;
    }

    $user = ['password' => $password];
    if (updateUser($user_id, $user)) {
        echo "success";
    } else {
        echo "Failed to update password.";
    }
    exit;
}
echo "Invalid request.";
?>