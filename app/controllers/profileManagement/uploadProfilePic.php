<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['avatarUpload']) && $_FILES['avatarUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatarUpload']['tmp_name'];
        $fileName = $_FILES['avatarUpload']['name'];
        $fileSize = $_FILES['avatarUpload']['size'];
        $fileType = $_FILES['avatarUpload']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = 'avatar'. $fileExtension;
            $uploadFileDir = '../../uploads/avatars/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!file_exists($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                header("../../views/profileManagement/profile.php?msg=Profile picture updated successfully.");
            } else {
                echo "Error moving the file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(", ", $allowedExtensions);
        }
    } else {
        echo "No file uploaded or upload error.";
    }
} else {
    echo "Invalid request method.";
}
?>
