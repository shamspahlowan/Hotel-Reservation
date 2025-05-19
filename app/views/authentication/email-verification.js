const showEmailEl = document.getElementById("showEmail");
if (showEmailEl && localStorage.getItem("userEmail")) {
  showEmailEl.textContent = localStorage.getItem("userEmail");
}

const form = document.getElementById("verifyForm");
const codeInput = document.getElementById("codeInput");
const msg = document.getElementById("msg");

if (form) {
  form.addEventListener("submit", function (e) {
    const value = codeInput.value.trim();
    if (value.length === 0) {
      e.preventDefault();
      msg.textContent = "Please enter the verification code.";
      msg.style.color = "red";
    }
  });
}
