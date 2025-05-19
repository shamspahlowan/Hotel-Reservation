<?php
session_start();

$email = $password = "";
$message = "";
$color = "red";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $message = "Email cannot be empty.";
    } else {
        $parts = explode('@', $email);
        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            $message = "Invalid email format.";
        } else {
            $domainParts = explode('.', $parts[1]);
            if (count($domainParts) < 2 || $domainParts[0] === '' || $domainParts[1] === '') {
                $message = "Email must be in the valid format (e.g., example@domain.com).";
            }
        }
    }

    if ($message === '') {
        if ($password === '') {
            $message = "Password cannot be empty.";
        } elseif (strlen($password) < 6) {
            $message = "Password must be at least 6 characters.";
        }
    }
    if ($message === '') {
        if ($email === "admin@admin.com" && $password === "123456") {
            echo "admin!";
            $_SESSION["isAdmin"] = "true";
            header("Location: ../../views/AdminPanel/admin.php");
            exit;
        } else {
            $_SESSION["status"] = "true";
            header("Location: ../../views/UserDashboard/user-dashboard.php");
            exit;
        }
    }
}
?>