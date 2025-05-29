document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").onsubmit = function (e) {
        e.preventDefault();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const error = document.getElementById("error");
        error.textContent = '';

        const parts = email.split('@');
        if (email === '' || parts.length !== 2 || !parts[0] || !parts[1]) {
            error.textContent = "Please enter a valid email.";
            return;
        }
        const domainParts = parts[1].split('.');
        if (domainParts.length < 2 || !domainParts[0] || !domainParts[1]) {
            error.textContent = "Please enter a valid email.";
            return;
        }
        if (password.length < 6) {
            error.textContent = "Password must be at least 6 characters.";
            return;
        }

        let json = {
            'email': email,
            'password': password
        };
        let data = JSON.stringify(json);

        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controllers/LoginController.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send('json=' + data);
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === "success") {
                    error.style.color = "var(--success-color)";
                    error.textContent = "Login successful! Redirecting...";
                    setTimeout(() => {
                        window.location.href = "../UserDashboard/user-dashboard.php";
                    }, 1000);
                } else if (this.responseText === "admin") {
                    error.style.color = "var(--success-color)";
                    error.textContent = "Admin login! Redirecting...";
                    setTimeout(() => {
                        window.location.href = "../AdminPanel/admin.php";
                    }, 1000);
                } else {
                    error.style.color = "var(--error-color)";
                    error.textContent = this.responseText;
                }
            }
        }
    };
});