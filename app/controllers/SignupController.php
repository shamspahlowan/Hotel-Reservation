<?php
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);

    $errors = [];
    if (strlen($data['username']) < 2) $errors[] = "Name must be at least 2 characters.";
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email address.";
    if (strlen($data['password']) < 6) $errors[] = "Password must be at least 6 characters.";

    $con = getConnection();
    $email = mysqli_real_escape_string($con, $data['email']);
    $check = mysqli_query($con, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) $errors[] = "Email already registered.";

    if (!empty($errors)) {
        echo implode("<br>", $errors);
        exit;
    }

    $user = [
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => $data['password']
    ];
    if (addUser($user)) {
        echo "Signup successful!";
    } else {
        echo "Signup failed. Please try again.";
    }
    exit;
}
?>