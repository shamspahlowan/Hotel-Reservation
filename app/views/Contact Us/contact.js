document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const subject = document.getElementById("subject").value.trim();
    const message = document.getElementById("message").value.trim();
    const captcha = document.getElementById("captcha").value.trim();
    const error = document.getElementById("formError");
  
    error.textContent = "";
  
    if (!name || !email || !subject || !message) {
      error.textContent = "Please fill in all fields.";
      return;
    }
  
    if (captcha !== "5") {
      error.textContent = "CAPTCHA is incorrect.";
      return;
    }
  
    // Simulate storing the message (could use backend instead)
    localStorage.setItem("contactSubmission", JSON.stringify({ name, email, subject, message }));
    window.location.href = "contact-submitted.html";
  });
  