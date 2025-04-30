document.getElementById("forgotForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const error = document.getElementById("error");

  error.textContent = "";

  if (email === "") {
    error.textContent = "Email cannot be empty.";
    return;
  }

  const parts = email.split("@");
  if (parts.length !== 2 || parts[0] === "" || parts[1] === "" || !parts[1].includes(".")) {
    error.textContent = "Invalid email format.";
    return;
  }

  // Simulate sending a verification code
  localStorage.setItem("verificationCode", "123456");
  localStorage.setItem("userEmail", email);

  window.location.href = "email-verification.html";
});
