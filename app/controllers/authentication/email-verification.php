<?php
session_start();

$error = '';
$success = '';

if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'pending_verification') {
    header("Location: ../../views/authentication/forgot-password.php");
    exit;
}

$email = $_SESSION['reset_email'] ?? '';
$code = $_SESSION['verification_code'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredCode = trim($_POST['code'] ?? '');

    if ($enteredCode === '') {
        $error = "Please enter the verification code.";
    } elseif ($enteredCode === $code) {
        $_SESSION['status'] = 'verified';
        $success = "Email verified successfully! Redirecting...";
        $_SESSION['success'] = $success;
        header("Location: ../../views/authentication/Resetpass.php");
        exit;
    } else {
        $error = "Invalid code. Please try again.";
    }
}

$_SESSION['error'] = $error;
$_SESSION['success'] = $success;

header("Location: ../../views/authentication/email-verification.php");
exit;
?>