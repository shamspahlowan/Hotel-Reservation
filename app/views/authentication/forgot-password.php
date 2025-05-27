<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password - NexStay</title>
  <link rel="stylesheet" href="forgot-password.css" />
</head>
<body>
  <div class="forgot-container">
    <h2>Forgot Password</h2>
    <form id="forgotForm" method="POST" action="javascript:void(0);">
      <input type="email" id="email" name="email" placeholder="Enter your email" required />
      <div id="msg"></div>
      <button type="submit">Send Verification Code</button>
    </form>
    <p class="link"><a href="login2.php">Back to Login</a></p>
  </div>
  <script src="forgot-password.js"></script>
</body>
</html>