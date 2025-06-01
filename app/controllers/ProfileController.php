<?php
session_start();
header('Content-Type: text/plain');
require_once('../models/UserModel.php');

if (!isset($_SESSION['status'])) {
    echo "Not logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $errors = [];

    if ($username === '') {
        $errors[] = "Name cannot be empty.";
    } elseif (strlen($username) < 2) {
        $errors[] = "Name must be at least 2 characters.";
    }

    $parts = explode('@', $email);
    if ($email === '' || count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
        $errors[] = "Invalid email format.";
    } else {
        $domainParts = explode('.', $parts[1]);
        if (count($domainParts) < 2 || $domainParts[0] === '' || $domainParts[1] === '') {
            $errors[] = "Email must be in valid format (e.g., example@domain.com).";
        }
    }

    $con = getConnection();
    $email_escaped = mysqli_real_escape_string($con, $email);
    $check = mysqli_query($con, "SELECT id FROM users WHERE email='$email_escaped' AND id != $user_id");
    if (mysqli_num_rows($check) > 0) {
        $errors[] = "Email already taken by another user.";
    }

    if (!empty($errors)) {
        echo implode("<br>", $errors);
        exit;
    }

    $avatarPath = null;
    if (isset($_FILES['avatarUpload']) && $_FILES['avatarUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatarUpload']['tmp_name'];
        $fileName = $_FILES['avatarUpload']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = "avatar_user{$user_id}_" . time() . "." . $fileExtension;
            $uploadFileDir = '../uploads/avatars/';
            
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $avatarPath = "uploads/avatars/" . $newFileName;
            } else {
                echo "Failed to upload image.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF allowed.";
            exit;
        }
    }

    $user = [
        'username' => $username,
        'email' => $email
    ];
    if ($avatarPath) {
        $user['avatar'] = $avatarPath;
    }

    if (updateUser($user_id, $user)) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        echo "success";
    } else {
        echo "Failed to update profile.";
    }
    exit;
}
echo "Invalid request.";
?>