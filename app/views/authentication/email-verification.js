const showEmailEl = document.getElementById("showEmail");
if (showEmailEl && localStorage.getItem("userEmail")) {
  showEmailEl.textContent = localStorage.getItem("userEmail");
}

const form = document.getElementById("verifyForm");
const codeInput = document.getElementById("codeInput");
const msg = document.getElementById("msg");

if (form) {
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const value = codeInput.value.trim();
    if (value.length !== 6 || isNaN(value)) {
      msg.textContent = "Please enter the 6-digit code.";
      msg.style.color = "red";
      return;
    }

    let json = { code: value };
    let data = JSON.stringify(json);

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/EmailVerificationController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('json=' + data);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        msg.textContent = this.responseText;
        msg.style.color = this.responseText.includes("verified") ? "green" : "red";
        if (this.responseText.includes("verified")) {
          setTimeout(() => {
            window.location.href = "Resetpass.php";
          }, 1200);
        }
      }
    }
  });
}