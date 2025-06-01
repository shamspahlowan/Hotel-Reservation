<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}
require_once('../../models/UserModel.php');
$user = getUserById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Profile - NexStay</title>
  <link rel="stylesheet" href="profile.css" />
</head>
<body>
  <div class="profile-container">
    <h2>My Profile</h2>

    <form id="profileForm" method="POST" action="javascript:void(0);" enctype="multipart/form-data">
      <div class="avatar-box">
        <img id="avatar" src="../../<?php echo htmlspecialchars($user['avatar'] ?? 'uploads/avatars/default.png'); ?>" alt="Profile Picture" />
        <input type="file" id="avatarUpload" name="avatarUpload" accept="image/*" />
      </div>
      
      <input type="text" id="username" name="username" placeholder="Full Name" value="<?php echo htmlspecialchars($user['username']); ?>" required disabled>
      <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required disabled>
      
      <div id="msg"></div>
      
      <button type="button" id="editBtn">Edit Profile</button>
      <button type="submit" id="saveBtn" style="display:none;">Save Changes</button>
    </form>

    <button type="button" id="changePassBtn">Change Password</button>
    <form id="passwordForm" method="POST" action="javascript:void(0);" style="display:none;">
      <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required>
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
      <div id="passMsg"></div>
      <button type="submit">Update Password</button>
      <button type="button" id="cancelPassBtn">Cancel</button>
    </form>
  </div>
  
  <script src="profile.js"></script>
</body>
</html>