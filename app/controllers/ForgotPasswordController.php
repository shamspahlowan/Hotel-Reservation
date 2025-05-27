<?php
session_start();
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);
    $email = trim($data['email'] ?? '');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Check if email exists in users table
    $user = getUserByEmail($email);
    if (!$user) {
        echo "No account found with this email.";
        exit;
    }

    // Generate a 6-digit code and store in session
    $code = rand(100000, 999999);
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_code'] = $code;
    $_SESSION['reset_verified'] = false;

    // TODO: Send $code to $email (implement your mail logic here)
    // mail($email, "Your NexStay Verification Code", "Your code is: $code");

    echo "Verification code sent to your email. Your code is: $code (copy the code)";
    exit;
}
?>