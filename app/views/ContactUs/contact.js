// contact.js

document.getElementById("contactForm")?.addEventListener("submit", function (e) {
  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim();
  const subject = document.getElementById("subject").value.trim();
  const message = document.getElementById("message").value.trim();
  const captcha = document.getElementById("captcha").value.trim();
  const error = document.getElementById("formError");

  if (error) error.textContent = "";

  if (!name || !email || !subject || !message) {
    e.preventDefault();
    if (error) error.textContent = "Please fill in all fields.";
    return;
  }

  const emailParts = email.split("@");
  if (
    emailParts.length !== 2 ||
    emailParts[0] === "" ||
    !emailParts[1].includes(".") ||
    emailParts[1].split(".").length < 2
  ) {
    e.preventDefault();
    if (error) error.textContent = "Invalid email format.";
    return;
  }

  if (captcha !== "5") {
    e.preventDefault();
    if (error) error.textContent = "CAPTCHA is incorrect.";
    return;
  }

  // Simulate success
  if (error) {
    error.style.color = "var(--success-color)";
    error.textContent = "Message sent successfully! (Simulated)";
  }
});
