document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const error = document.getElementById("error");

  
    error.textContent = '';

   
    if (!validateEmail(email)) {
        error.textContent = "Please enter a valid email.";
        return;
    }

    
    if (password.length < 6) {
        error.textContent = "Password must be at least 6 characters.";
        return;
    }
    error.style.color = "green";
    error.textContent = "Login successful!";
});

function validateEmail(email) {
    const emailParts = email.split('@');
    if (emailParts.length !== 2) return false;

    const [username, domain] = emailParts;
    if (!username || !domain) return false;

    const domainParts = domain.split('.');
    if (domainParts.length !== 2) return false;

    const [subdomain, com] = domainParts;
    if (!subdomain || !com) return false;

    return true;
}
