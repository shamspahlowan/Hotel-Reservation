<?php
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // TODO: Check if the email exists in your user database
        // Example mock check:
        $mockRegisteredEmail = "test@example.com";

        if ($email === $mockRegisteredEmail) {
            // Simulate generating and sending a verification code
            $verificationCode = rand(100000, 999999);

            // Save to session and/or cookie
            $_SESSION['reset_email'] = $email;
            $_SESSION['verification_code'] = $verificationCode;

            // Optionally store in a cookie (expires in 5 minutes)
            setcookie("reset_email", $email, time() + 300, "/");

            // Simulate sending email (implement in real app)
            // mail($email, "Your Verification Code", "Code: $verificationCode");

            header("Location: verify-code.php");
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
  <title>Forgot Password - Hotel Reservation</title>
  <link rel="stylesheet" href="forgot-password.css" />
</head>
<body>
  <div class="forgot-container">
    <h2>Forgot Password</h2>
    <form id="forgotForm" method="POST" action="">
      <input type="email" name="email" id="email" placeholder="Enter your registered email" required />

      <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
      <?php endif; ?>

      <input type="submit" name="submit" value="Submit">
    </form>
    <p class="link">Back to <a href="login.php">Login</a></p>
  </div>

  <script src="forgot-password.js"></script>
</body>
</html>
