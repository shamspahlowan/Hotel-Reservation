<?php
session_start();

$email = $_SESSION['reset_email'] ?? '';
$code = $_SESSION['verification_code'] ?? '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $enteredCode = trim($_POST['code'] ?? '');

  if ($enteredCode === '') {
    $error = "Please enter the verification code.";
  } elseif ($enteredCode === $code) {
    $success = "Email verified successfully! Redirecting...";
    echo "<script>setTimeout(() => window.location.href = 'reset-password.php', 1500);</script>";
  } else {
    $error = "Invalid code. Please try again.";
  }
}
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
    <form method="POST" action="">
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