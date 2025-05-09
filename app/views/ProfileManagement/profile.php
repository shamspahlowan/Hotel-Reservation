<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login.php");
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

    <div class="avatar-box">
      <img id="avatar" src="default-avatar.png" alt="Profile Picture" />
      <input type="file" id="avatarUpload" accept="image/*" />
    </div>

    <form id="profileForm">
      <input type="text" id="name" value="John Doe" disabled />
      <input type="email" id="email" value="john@example.com" disabled />
      <button type="button" id="editBtn">Edit Profile</button>
      <button type="submit" id="saveBtn" style="display:none;">Save Changes</button>
    </form>

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
