document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("forgotForm");
  const msg = document.getElementById("msg");

  form.onsubmit = function (e) {
    e.preventDefault();
    const email = document.getElementById("email").value.trim();

    if (
      email.length < 6 ||
      email.indexOf("@") === -1 ||
      email.indexOf(".") === -1 ||
      email.indexOf("@") === 0 ||
      email.lastIndexOf(".") < email.indexOf("@") + 2 ||
      email.endsWith(".")
    ) {
      msg.textContent = "Please enter a valid email address.";
      msg.style.color = "red";
      return;
    }

    let json = { email: email };
    let data = JSON.stringify(json);

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/ForgotPasswordController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('json=' + data);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        msg.textContent = this.responseText;
        msg.style.color = this.responseText.includes("sent") ? "green" : "red";
        if (this.responseText.includes("sent")) {
          localStorage.setItem("userEmail", email);
          setTimeout(() => {
            window.location.href = "email-verification.php";
          }, 7200);
        }
      }
    }
  };
});