document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
  
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const error = document.getElementById('error');
  
    error.textContent = '';
  
    if (newPassword.length < 6) {
      error.textContent = "Password must be at least 6 characters.";
      return;
    }
  
    if (newPassword !== confirmPassword) {
      error.textContent = "Passwords do not match.";
      return;
    }
  
    error.style.color = "green";
    error.textContent = "Password reset successful! (Simulated)";
  });
  