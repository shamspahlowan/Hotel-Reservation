document.getElementById("signupForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
    const error = document.getElementById("error");
    const errorSuccess = document.getElementById("errorSuccess");

    error.textContent = '';
    errorSuccess.textContent = '';

    
    if (name.length < 2) {
        error.textContent = "Name must be at least 2 characters.";
        return;
    }

    
    if (!validateEmail(email)) {
        error.textContent = "Enter a valid email.";
        return;
    }

    
    if (password.length < 6) {
        error.textContent = "Password must be at least 6 characters.";
        return;
    }

    
    if (password !== confirmPassword) {
        error.textContent = "Passwords do not match.";
        return;
    }

    
    errorSuccess.textContent = "Signup successful! (Simulated)";
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
