// profile.js
const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const editBtn = document.getElementById("editBtn");
const saveBtn = document.getElementById("saveBtn");
const msg = document.getElementById("msg");

editBtn.addEventListener("click", function () {
  nameInput.disabled = false;
  editBtn.style.display = "none";
  saveBtn.style.display = "inline-block";
});

document.getElementById("profileForm").addEventListener("submit", function (e) {
  const name = nameInput.value.trim();

  if (name.length < 2) {
    e.preventDefault();
    showMessage("Name must be at least 2 characters.", "red");
    return;
  }

  showMessage("Profile updated successfully!", "green");
  nameInput.disabled = true;
  saveBtn.style.display = "none";
  editBtn.style.display = "inline-block";
});

function togglePasswordBox() {
  const box = document.getElementById("passwordBox");
  box.style.display = box.style.display === "none" ? "block" : "none";
}

function updatePassword() {
  const newPass = document.getElementById("newPassword").value;
  const confirmPass = document.getElementById("confirmPassword").value;

  if (newPass.length < 6) {
    showMessage("Password must be at least 6 characters.", "red");
    return;
  }

  if (newPass !== confirmPass) {
    showMessage("Passwords do not match.", "red");
    return;
  }

  showMessage("Password changed successfully!", "green");
}

function showMessage(text, color) {
  msg.textContent = text;
  msg.style.color = color;
}

document.getElementById("avatarUpload").addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("avatar").src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
