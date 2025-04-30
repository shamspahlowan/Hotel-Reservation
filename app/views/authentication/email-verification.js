document.getElementById("showEmail").textContent = localStorage.getItem("userEmail") || "[unknown]";

document.getElementById("verifyForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const enteredCode = document.getElementById("codeInput").value.trim();
  const realCode = localStorage.getItem("verificationCode");
  const msg = document.getElementById("msg");

  if (enteredCode === "") {
    msg.textContent = "Please enter the verification code.";
    return;
  }

  if (enteredCode === realCode) {
    msg.style.color = "green";
    msg.textContent = "Email verified successfully! Redirecting...";
    setTimeout(() => {
      window.location.href = "reset-password.html";
    }, 1500);
  } else {
    msg.style.color = "red";
    msg.textContent = "Invalid code. Please try again.";
  }
});
