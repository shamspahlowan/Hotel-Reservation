<?php
session_start();


$email = $_SESSION['reset_email'] ?? '';
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';


unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Email Verification</title>
  <link rel="stylesheet" href="email-verification.css" />
</head>
<body>
  <div class="verify-box">
    <h2>Email Verification</h2>
    <p>We've sent a 6-digit code to your email: <strong><?= htmlspecialchars($email) ?: '[unknown]' ?></strong></p>
    <form method="POST" action="../../controllers/authentication/email-verification.php">
      <input type="text" name="code" placeholder="Enter code" maxlength="6" required />

      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <button type="submit">Verify</button>
    </form>
  </div>
  <script src="email-verification.js"></script>
</body>
</html>