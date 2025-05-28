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
  <title>Email Verification - NexStay</title>
  <link rel="stylesheet" href="email-verification.css" />
</head>
<body>
  <div class="verify-box">
    <h2>Email Verification</h2>
    <p>Enter the 6-digit code sent to <span id="showEmail"></span></p>
    <form id="verifyForm" method="POST" action="javascript:void(0);">
      <input type="text" id="codeInput" maxlength="6" placeholder="Enter code" required />
      <div id="msg"></div>
      <button type="submit">Verify</button>
    </form>
    <p class="link"><a href="forgot-password.php">Back</a></p>
  </div>
  <script src="email-verification.js"></script>
</body>
</html>