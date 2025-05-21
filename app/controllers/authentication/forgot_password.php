<?php
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $mockRegisteredEmail = "test@example.com"; 

        if ($email === $mockRegisteredEmail) {
            $verificationCode = '123456'; 

            $_SESSION['reset_email'] = $email;
            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['status'] = 'pending_verification';
            setcookie("reset_email", $email, time() + 300, "/");

            header("Location: ../../views/authentication/email-verification.php");
            exit;
        } else {
            $error = "This email is not registered.";
        }
    }
}


$_SESSION['error'] = $error;
$_SESSION['success'] = $success;


header("Location: ../../views/authentication/forgot_password.php");
exit;
?>
