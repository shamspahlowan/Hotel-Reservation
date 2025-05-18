document.getElementById('resetForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const error = document.getElementById('error');

    error.textContent = '';
    error.style.color = 'var(--error-color)';

    if (newPassword.length < 6) {
        e.preventDefault();
        error.textContent = "Password must be at least 6 characters.";
        return;
    }

    if (newPassword !== confirmPassword) {
        e.preventDefault();
        error.textContent = "Passwords do not match.";
        return;
    }

    error.style.color = 'var(--success-color)';
    error.textContent = "Password reset successful! (Client-side)";
});
