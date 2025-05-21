<?php
session_start();

// Retrieve error/success messages from session
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

// Clear session messages after retrieval
unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password - NexStay</title>
  <link rel="stylesheet" href="forgot-password.css" />
</head>
<body>
  <div class="forgot-container">
    <h2>Forgot Password</h2>
    <form id="forgotForm" method="POST" action="../../controllers/authentication/forgot_password.php">
      <input type="email" name="email" id="email" placeholder="Enter your registered email" required />

      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <button type="submit" name="submit">Submit</button>
    </form>
    <p class="link">Back to <a href="../authentication/login2.php">Login</a></p>
  </div>

  <script src="forgot-password.js"></script>
</body>
</html>