document.getElementById("forgotForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const emailInput = document.getElementById("email");
    const error = document.getElementById("error");
    const email = emailInput.value.trim();
  
    error.textContent = "";
  
    if (email === "") {
      error.textContent = "Email cannot be empty.";
      error.style.color = "red";
      return;
    }
  
    const parts = email.split("@");
  
    if (parts.length !== 2) {
      error.textContent = "Invalid email format.";
      error.style.color = "red";
      return;
    }
  
    const [username, domain] = parts;
  
    if (username === "" || domain === "") {
      error.textContent = "Invalid email format.";
      error.style.color = "red";
      return;
    }
  
    const domainParts = domain.split(".");
    if (domainParts.length !== 2) {
      error.textContent = "Email must be in the valid format (e.g., example@domain.com).";
      error.style.color = "red";
      return;
    }
  
    const [subdomain, tld] = domainParts;
    if (subdomain === "" || tld === "") {
      error.textContent = "Email must be in the valid format (e.g., example@domain.com).";
      error.style.color = "red";
      return;
    }
  
    error.style.color = "green";
    error.textContent = "Reset link has been sent! (Simulated)";
  });
  