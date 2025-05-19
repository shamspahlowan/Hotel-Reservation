<?php

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

    <form id="loginForm" method="POST" action="../../controllers/authentication/Login.php">
      <input type="email" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <p id="error" class="error"></p>
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
