document.getElementById("loginForm").addEventListener("submit", function (e) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const error = document.getElementById("error");

    error.textContent = '';
    error.classList.remove("success");

    if (!validateEmail(email)) {
        e.preventDefault();
        error.textContent = "Please enter a valid email.";
        return;
    }

    if (password.length < 6) {
        e.preventDefault();
        error.textContent = "Password must be at least 6 characters.";
        return;
    }

    error.style.color = "var(--success-color)";
    error.textContent = "Login successful! (Client-side)";
});

function validateEmail(email) {
    const parts = email.split('@');
    if (parts.length !== 2 || !parts[0] || !parts[1]) return false;

    const domainParts = parts[1].split('.');
    return domainParts.length >= 2 && !domainParts.includes('');
}
