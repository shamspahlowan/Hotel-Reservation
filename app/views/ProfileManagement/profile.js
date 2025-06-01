document.addEventListener("DOMContentLoaded", function () {
  const profileForm = document.getElementById("profileForm");
  const passwordForm = document.getElementById("passwordForm");
  const usernameInput = document.getElementById("username");
  const emailInput = document.getElementById("email");
  const avatarUpload = document.getElementById("avatarUpload");
  const avatar = document.getElementById("avatar");
  const editBtn = document.getElementById("editBtn");
  const saveBtn = document.getElementById("saveBtn");
  const changePassBtn = document.getElementById("changePassBtn");
  const cancelPassBtn = document.getElementById("cancelPassBtn");
  const msg = document.getElementById("msg");
  const passMsg = document.getElementById("passMsg");

  avatarUpload.addEventListener("change", function () {
    if (this.files && this.files[0]) {
      const reader = new FileReader();
      reader.onload = function (e) {
        avatar.src = e.target.result;
      };
      reader.readAsDataURL(this.files[0]);
    }
  });

  editBtn.addEventListener("click", function () {
    usernameInput.disabled = false;
    emailInput.disabled = false;
    editBtn.style.display = "none";
    saveBtn.style.display = "inline-block";
  });

  profileForm.onsubmit = function (e) {
    e.preventDefault();
    
    const username = usernameInput.value.trim();
    const email = emailInput.value.trim();
    msg.innerHTML = "";

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

    const formData = new FormData();
    formData.append("username", username);
    formData.append("email", email);
    if (avatarUpload.files[0]) {
      formData.append("avatarUpload", avatarUpload.files[0]);
    }

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/ProfileController.php', true);
    xhttp.send(formData);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText === "success") {
          msg.style.color = "green";
          msg.innerHTML = "Profile updated successfully!";
          usernameInput.disabled = true;
          emailInput.disabled = true;
          saveBtn.style.display = "none";
          editBtn.style.display = "inline-block";
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          msg.style.color = "red";
          msg.innerHTML = this.responseText;
        }
      }
    }
  };

  passwordForm.onsubmit = function (e) {
    e.preventDefault();
    
    const newPassword = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    passMsg.innerHTML = "";

    if (newPassword.length < 6) {
      passMsg.innerHTML = "Password must be at least 6 characters.";
      return;
    }
    if (newPassword !== confirmPassword) {
      passMsg.innerHTML = "Passwords do not match.";
      return;
    }

    let json = {
      'password': newPassword
    };
    let data = JSON.stringify(json);

    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/PasswordController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('json=' + data);
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText === "success") {
          passMsg.style.color = "green";
          passMsg.innerHTML = "Password updated successfully!";
          passwordForm.style.display = "none";
          document.getElementById("newPassword").value = "";
          document.getElementById("confirmPassword").value = "";
        } else {
          passMsg.style.color = "red";
          passMsg.innerHTML = this.responseText;
        }
      }
    }
  };

  changePassBtn.addEventListener("click", function () {
    passwordForm.style.display = "block";
  });

  cancelPassBtn.addEventListener("click", function () {
    passwordForm.style.display = "none";
    document.getElementById("newPassword").value = "";
    document.getElementById("confirmPassword").value = "";
    passMsg.innerHTML = "";
  });
});