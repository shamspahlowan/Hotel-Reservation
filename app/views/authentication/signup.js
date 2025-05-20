document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signupForm');
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirm = document.getElementById('confirmPassword');
    const passwordStrengthBar = document.querySelector('.password-strength-bar');

    function isValidEmail(email) {
        return email.includes("@") && email.includes(".") && email.length >= 5;
    }

    function getPasswordStrength(password) {
        let hasUpper = false, hasLower = false, hasNumber = false, hasSymbol = false;

        for (let i = 0; i < password.length; i++) {
            const char = password[i];
            const code = char.charCodeAt(0);

            if (code >= 65 && code <= 90) hasUpper = true;
            else if (code >= 97 && code <= 122) hasLower = true;
            else if (code >= 48 && code <= 57) hasNumber = true;
            else hasSymbol = true;
        }

        let score = 0;
        if (password.length >= 6) score++;
        if (password.length >= 10) score++;
        if (hasUpper && hasLower) score++;
        if (hasNumber) score++;
        if (hasSymbol) score++;

        return score;
    }

    password.addEventListener('input', function () {
        const strength = getPasswordStrength(password.value);
        passwordStrengthBar.className = 'password-strength-bar';

        if (password.value === '') {
            passwordStrengthBar.style.width = '0';
        } else if (strength <= 2) {
            passwordStrengthBar.classList.add('weak');
        } else if (strength <= 4) {
            passwordStrengthBar.classList.add('medium');
        } else {
            passwordStrengthBar.classList.add('strong');
        }
    });

    form.addEventListener('submit', function (e) {
        const errors = [];

        if (name.value.trim().length < 2) {
            errors.push("Name must be at least 2 characters.");
        }

        if (!isValidEmail(email.value)) {
            errors.push("Invalid email address.");
        }

        if (password.value.length < 6) {
            errors.push("Password must be at least 6 characters.");
        }

        if (password.value !== confirm.value) {
            errors.push("Passwords do not match.");
        }

        const errorBox = document.querySelector('.error');
        if (errorBox) errorBox.innerHTML = '';

        if (errors.length > 0) {
            e.preventDefault();
            if (errorBox) {
                errorBox.classList.add('active');
                errors.forEach(err => {
                    const li = document.createElement('li');
                    li.textContent = err;
                    errorBox.appendChild(li);
                });
            }
        }
    });
});
