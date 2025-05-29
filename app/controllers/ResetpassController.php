<?php
session_start();
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);
    $password = $data['password'] ?? '';

    if (!isset($_SESSION['reset_email']) || !$_SESSION['reset_verified']) {
        echo "Session expired or not verified.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
        exit;
    }

    $email = $_SESSION['reset_email'];
    if (updateUserPasswordByEmail($email, $password)) {
        unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_verified']);
        echo "Password reset success! You can now login.";
    } else {
        echo "Failed to reset password. Please try again.";
    }
    exit;
}
?>