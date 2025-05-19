<?php

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $mockRegisteredEmail = "test@example.com"; // Simulated check

        if ($email === $mockRegisteredEmail) {
            $verificationCode = rand(100000, 999999);

            $_SESSION['reset_email'] = $email;
            $_SESSION['verification_code'] = $verificationCode;
            setcookie("reset_email", $email, time() + 300, "/");

            header("Location: email-verification.php");
            exit;
        } else {
            $error = "This email is not registered.";
        }
    }
}
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
    <form id="forgotForm" method="POST" action="">
      <input type="email" name="email" id="email" placeholder="Enter your registered email" required />

      <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <button type="submit" name="submit">Submit</button>
    </form>
    <p class="link">Back to <a href="login2.php">Login</a></p>
  </div>

  <script src="forgot-password.js"></script>
</body>
</html>