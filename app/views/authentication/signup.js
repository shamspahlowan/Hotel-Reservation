document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("signupForm");
  form.onsubmit = function (e) {
    e.preventDefault();
    let username = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let msg = document.getElementById("msg");

    if (username.length < 2) {
      msg.innerHTML = "Name must be at least 2 characters.";
      return;
    }
    if (
      email.length < 6 ||
      email.indexOf("@") === -1 ||
      email.indexOf(".") === -1 ||
      email.indexOf("@") === 0 ||
      email.lastIndexOf(".") < email.indexOf("@") + 2 ||
      email.endsWith(".")
    ) {
      msg.innerHTML = "Invalid email address.";
      return;
    }
    if (password.length < 6) {
      msg.innerHTML = "Password must be at least 6 characters.";
      return;
    }
    if (password !== confirmPassword) {
      msg.innerHTML = "Passwords do not match.";
      return;
    }

    let json = {
      username: username,
      email: email,
      password: password,
    };
    let data = JSON.stringify(json);

    let xhttp = new XMLHttpRequest();
    xhttp.open(
      "POST",
      "../../controllers/SignupController.php",
      true
    );
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("json=" + data);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        msg.innerHTML = this.responseText;
        if (this.responseText.includes("successful")) {
          setTimeout(() => {
            window.location.href = "login2.php";
          }, 1500);
        }
      }
    };
  };
});
