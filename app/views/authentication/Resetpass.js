document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("resetForm");
  const msg = document.getElementById("msg");

  form.onsubmit = function (e) {
    e.preventDefault();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password.length < 6) {
      msg.textContent = "Password must be at least 6 characters.";
      msg.style.color = "red";
      return;
    }
    if (password !== confirmPassword) {
      msg.textContent = "Passwords do not match.";
      msg.style.color = "red";
      return;
    }

    let json = { password: password };
    let data = JSON.stringify(json);

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/authentication/ResetpassController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('json=' + data);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        msg.textContent = this.responseText;
        msg.style.color = this.responseText.includes("success") ? "green" : "red";
        if (this.responseText.includes("success")) {
          setTimeout(() => {
            window.location.href = "login2.php";
          }, 1200);
        }
      }
    }
  };
});