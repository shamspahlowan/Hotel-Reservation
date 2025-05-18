<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $captcha = trim($_POST['captcha'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($captcha !== '5') {
        $error = "CAPTCHA is incorrect.";
    } else {
        // Simulated success (redirect to thank you page)
        header("Location: contact-submitted.html");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - NexStay</title>
  <link rel="stylesheet" href="contact2.css" />
</head>
<body>
  <div class="contact-container">
    <h2>Contact Us</h2>
    <form method="POST" action="" id="contactForm">
      <input type="text" name="name" id="name" placeholder="Your Name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" />
      <input type="email" name="email" id="email" placeholder="Your Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
      <input type="text" name="subject" id="subject" placeholder="Subject" required value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" />
      <textarea name="message" id="message" placeholder="Your Message" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>

      <label for="captcha">What is 2 + 3?</label>
      <input type="text" name="captcha" id="captcha" placeholder="Answer" required />

      <?php if ($error): ?>
        <p class="error" id="formError"><?= htmlspecialchars($error) ?></p>
      <?php else: ?>
        <p class="error" id="formError"></p>
      <?php endif; ?>

      <button type="submit">Send Message</button>
    </form>
  </div>

  <script src="contact.js"></script>
</body>
</html>
