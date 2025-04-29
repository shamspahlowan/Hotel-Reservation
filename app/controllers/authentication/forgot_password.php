<?php
$email = $newPassword = $retypePassword = "";
$message = "";
$color = "red";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $newPassword = $_POST['new_password'] ?? '';
    $retypePassword = $_POST['retype_password'] ?? '';

    if ($email === '') {
        $message = "Email cannot be empty.";
    } else {
        $parts = explode('@', $email);
        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            $message = "Invalid email format.";
        } else {
            $domainParts = explode('.', $parts[1]);
            if (count($domainParts) !== 2 || $domainParts[0] === '' || $domainParts[1] === '') {
                $message = "Email must be in the valid format (e.g., example@domain.com).";
            }
        }
    }

    if (empty($message)) {
        if ($newPassword === '' || $retypePassword === '') {
            $message = "Password fields cannot be empty.";
        } elseif ($newPassword !== $retypePassword) {
            $message = "Passwords do not match.";
        } else {
            $message = "Password reset successful!";
            $color = "green";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - Hotel Reservation</title>
  <link rel="stylesheet" href="forgot-password.css" />
</head>
<body>
  <div class="forgot-container">
    <h2>Reset Password</h2>
    <form id="forgotForm" method="POST" action="../../views/authentication/login.html">
      <input type="email" name="email" id="email" placeholder="Enter your registered email" required value="<?= htmlspecialchars($email) ?>" />

      <input type="password" name="new_password" placeholder="New Password" required />
      <input type="password" name="retype_password" placeholder="Retype New Password" required />

      <?php if (!empty($message)): ?>
        <p id="error" class="error" style="color: <?= $color ?>;"><?= $message ?></p>
      <?php endif; ?>

      <input type="submit" name="submit" value="Reset Password" />
    </form>
    </p>
  </div>
</body>
</html>
