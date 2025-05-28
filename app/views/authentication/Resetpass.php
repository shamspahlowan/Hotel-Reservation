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
  <title>Reset Password - NexStay</title>
  <link rel="stylesheet" href="Resetpass.css" />
</head>
<body>
  <div class="signup-container">
    <h2>Reset Password</h2>
    <form id="resetForm" method="POST" action="javascript:void(0);">
      <input type="password" id="password" placeholder="New Password" required />
      <input type="password" id="confirmPassword" placeholder="Confirm Password" required />
      <div id="msg"></div>
      <button type="submit">Reset Password</button>
    </form>
    <p class="link"><a href="login2.php">Back to Login</a></p>
  </div>
  <script src="Resetpass.js"></script>
</body>
</html>