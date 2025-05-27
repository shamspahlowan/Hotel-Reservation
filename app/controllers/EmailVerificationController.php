<?php
session_start();
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);
    $code = trim($data['code'] ?? '');

    if (!isset($_SESSION['reset_code']) || !isset($_SESSION['reset_email'])) {
        echo "Session expired. Please try again.";
        exit;
    }

    if ($code == $_SESSION['reset_code']) {
        $_SESSION['reset_verified'] = true;
        echo "Email verified! You can now reset your password.";
    } else {
        echo "Invalid verification code.";
    }
    exit;
}
?>