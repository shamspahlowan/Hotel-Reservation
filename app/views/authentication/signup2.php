<?php
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

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

    if (empty($errors)) {
        $success = "Signup successful!";
        setcookie("user_email", $email, time() + 3600, "/");
        setcookie("user_pass", $password,time() + 3600, "/");
        $_SESSION['user_name'] = $name;
     

        header("location: ../../views/authentication/login2.php");
        exit;

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sign Up - NexStay</title>
    <link rel="stylesheet" href="signup.css" />
</head>
<body>
    <div class="signup-container">
        <div class="logo"><span>NexStay</span></div>
        <h2>Create Account</h2>

        <form id="signupForm" method="POST" action="">
            <input type="text" id="name" name="name" placeholder="Full Name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            <input type="email" id="email" name="email" placeholder="Email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="password-strength"><div class="password-strength-bar"></div></div>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>

            <?php if (!empty($errors)): ?>
                <ul class="error active">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if ($success): ?>
                <p class="success active"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <button type="submit" id="submitButton">Sign Up</button>
        </form>

        <p class="link">Already have an account? <a href="login2.php">Login</a></p>
    </div>

    <script src="signup.js"></script>
</body>
</html>
<?