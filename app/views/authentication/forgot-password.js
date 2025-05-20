
document.getElementById("forgotForm").addEventListener("submit", function (e) {
  const email = document.getElementById("email").value.trim();
  const error = document.getElementById("error");

  if (error) error.textContent = "";

  if (email === "") {
    e.preventDefault();
    if (error) error.textContent = "Email cannot be empty.";
    return;
  }

  const parts = email.split("@");
  if (parts.length !== 2 || parts[0] === "" || parts[1] === "" || !parts[1].includes(".")) {
    e.preventDefault();
    if (error) error.textContent = "Invalid email format.";
    return;
  }

 
});
