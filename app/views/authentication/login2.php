<?php
session_start(); // Required to use $_SESSION

$email = $password = "";
$message = "";
$color = "red";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $message = "Email cannot be empty.";
    } else {
        $parts = explode('@', $email);
        if (count($parts) !== 2 || $parts[0] === '' || $parts[1] === '') {
            $message = "Invalid email format.";
        } else {
            $domainParts = explode('.', $parts[1]);
            if (count($domainParts) < 2 || in_array('', $domainParts)) {
                $message = "Email must be in the valid format (e.g., example@domain.com).";
            }
        }
    }

    if (empty($message)) {
        if ($password === '') {
            $message = "Password cannot be empty.";
        } elseif (strlen($password) < 6) {
            $message = "Password must be at least 6 characters.";
        } else {
            // ✅ Login successful — set session and redirect
            $_SESSION['status'] = true;
            header("Location: ../../views/UserDashboard/user-dashboard.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - NexStay</title>
  <link rel="stylesheet" href="login2.css" />
</head>
<body>
  <div class="signup-container">
    <div class="logo"><span style="font-size: 24px; font-weight: 600; color: var(--brand-color);">NexStay</span></div>
    <h2>Login</h2>

    <form id="loginForm" method="POST" action="">
      <input type="email" id="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($email) ?>" />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <p id="error" class="error"><?= htmlspecialchars($message) ?></p>
      <button type="submit" name="submit">Login</button>
    </form>

    <p class="link">
      Don't have an account? <a href="signup2.php">Sign Up</a><br />
      <a href="forgot-password.php">Forgot Password?</a>
    </p>
  </div>

  <script src="login2.js"></script>
</body>
</html>
