<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Hotel Reservation</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form id="loginForm" action="../../controllers/authentication/Login.php" method="POST">
      <input type="email" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <p id="error" class="error"></p>
      <button type="submit" name="submit">Login</button>
    </form>
    <p class="link">
      Don't have an account? <a href="signup.php">Sign Up</a><br />
      <a href="forgot-password.php">Forgot Password?</a>
    </p>
  </div>
</body>
</html>
