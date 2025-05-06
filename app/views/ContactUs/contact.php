<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="contact.css" />
</head>
<body>
  <div class="contact-container">
    <h2>Contact Us</h2>
    <form id="contactForm">
      <input type="text" id="name" placeholder="Your Name" required />
      <input type="email" id="email" placeholder="Your Email" required />
      <input type="text" id="subject" placeholder="Subject" required />
      <textarea id="message" placeholder="Your Message" required></textarea>

      <label for="captcha">What is 2 + 3?</label>
      <input type="text" id="captcha" placeholder="Answer" required />

      <p class="error" id="formError"></p>
      <button type="submit">Send Message</button>
    </form>
  </div>

  <script src="contact.js"></script>
</body>
</html>
