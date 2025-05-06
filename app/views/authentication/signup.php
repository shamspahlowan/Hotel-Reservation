<?php
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Server-side validation
    if (strlen($name) < 2) {
        $errors[] = "Name must be at least 2 characters.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // If valid, simulate storing and set a session or cookie
    if (empty($errors)) {
        // You would normally store the user to a database here
        $success = "Signup successful!";
        setcookie("user_email", $email, time() + 3600, "/"); // optional cookie
        $_SESSION['user_name'] = $name; // optional session

        // Optionally redirect to another page
        // header('Location: welcome.php');
        // exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Signup - Hotel Reservation</title>
  <link rel="stylesheet" href="signup.css" />
</head>
<body>
  <div class="signup-container">
    <h2>Create Account</h2>
    <form id="signupForm" method="POST" action="">
      <input type="text" id="name" name="name" placeholder="Full Name" required />
      <input type="email" id="email" name="email" placeholder="Email" required />
      <input type="password" id="password" name="password" placeholder="Password" required />
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
      
      <?php if (!empty($errors)): ?>
        <ul class="error">
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>

      <?php if ($success): ?>
        <p class="success"><?php echo htmlspecialchars($success); ?></p>
      <?php endif; ?>

      <button type="submit">Sign Up</button>
    </form>
    <p class="link">Already have an account? <a href="login.php">Login</a></p>
  </div>

  <script src="signup.js"></script>
</body>
</html>
