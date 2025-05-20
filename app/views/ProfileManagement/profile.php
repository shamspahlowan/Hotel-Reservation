<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile</title>
  <link rel="stylesheet" href="profile.css" />
</head>
<body>
  <div class="profile-container">
    <h2>My Profile</h2>
    <form id="profileForm" action="../../controllers/profileManagement/uploadProfilePic.php" method="POST" enctype="multipart/form-data">
      <div class="avatar-box">
        <img id="avatar" src="../../../public/assets/defaultProfileImage.png" alt="Profile Picture" />
        <input type="file" id="avatarUpload" name="avatarUpload" accept="image/*" />
      </div>

      <input type="text" id="name" name="name" value="John Doe" disabled />
      <input type="email" id="email" name="email" value="john@example.com" disabled />

      <button type="submit" id="saveBtn">Save Changes</button>
    </form>

    <button id="editBtn">Edit Profile</button>
    <button onclick="togglePasswordBox()">Change Password</button>

    <div id="passwordBox" style="display:none;">
      <input type="password" id="newPassword" placeholder="New Password" />
      <input type="password" id="confirmPassword" placeholder="Confirm Password" />
      <button onclick="updatePassword()">Update Password</button>
    </div>

    <p id="msg" class="msg"></p>
  </div>

  <script src="profile.js"></script>
</body>
</html>
