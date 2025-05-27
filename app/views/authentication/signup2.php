<?php
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
        <form id="signupForm" method="POST" action="javascript:void(0);">
            <input type="text" id="name" name="name" placeholder="Full Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <div class="password-strength">
                <div class="password-strength-bar"></div>
            </div>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
            <div id="msg"></div>
            <button type="submit" id="submitButton">Sign Up</button>
        </form>
        <p class="link">Already have an account? <a href="login2.php">Login</a></p>
    </div>
    <script src="signup.js"></script>
</body>
</html>