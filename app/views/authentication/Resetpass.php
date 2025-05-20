<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}
// if (!isset($_SESSION['status'])) {
//     header("Location: ../../views/authentication/login2.php");
//     exit;
// }
$newPassword = $confirmPassword = "";
$message = "";
$color = "red";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($newPassword === '' || $confirmPassword === '') {
        $message = "Password fields cannot be empty.";
    } elseif (strlen($newPassword) < 6) {
        $message = "Password must be at least 6 characters.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        $message = "Password reset successful!";
        $color = "green";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password - NexStay</title>
  <link rel="stylesheet" href="Resetpass.css" />
</head>
<body>
  <div class="signup-container">
    <div class="logo"><span style="font-size: 24px; font-weight: 600; color: var(--brand-color);">NexStay</span></div>
    <h2>Reset Password</h2>
    <form id="resetForm" method="POST" action="">
      <input type="password" id="newPassword" name="new_password" placeholder="New Password" required />
      <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required />
      <p class="error" id="error" style="color: <?= $color ?>;"> <?= htmlspecialchars($message) ?> </p>
      <button type="submit" name="submit">Reset Password</button>
    </form>
  </div>
  <script src="Resetpass.js"></script>
</body>
</html>
