const users = [
    { id: 1, name: 'Alice', role: 'Admin' },
    { id: 2, name: 'Bob', role: 'Editor' },
    { id: 3, name: 'Charlie', role: 'User' },
    { id: 4, name: 'Diana', role: 'User' },
    { id: 5, name: 'Ethan', role: 'Editor' }
  ];
  
  function populateUserTable() {
    const tbody = document.getElementById('user-table');
    tbody.innerHTML = '';
    users.forEach(user => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.role}</td>
        <td>
          <select id="role-select-${user.id}">
            <option value="Admin">Admin</option>
            <option value="Editor">Editor</option>
            <option value="User">User</option>
          </select>
        </td>
        <td><button onclick="assignRole(${user.id})">Assign</button></td>
      `;
      tbody.appendChild(row);
    });
  }
  
  function assignRole(userId) {
    const selectedRole = document.getElementById(`role-select-${userId}`).value;
    for (let i = 0; i < users.length; i++) {
      if (users[i].id === userId) {
        users[i].role = selectedRole;
        break;
      }
    }
    populateUserTable();
    alert('Role updated successfully.');
  }
  
  function savePermissions() {
    const role = document.getElementById('role-select').value;
    const checkboxes = document.querySelectorAll('#permission-form input[type=checkbox]');
    const selected = [];
    checkboxes.forEach(chk => {
      if (chk.checked) selected.push(chk.value);
    });
    alert(`Permissions saved for ${role}: ${selected.join(', ')}`);
  }
  
  function updateVisibleFeatures() {
    const role = document.getElementById('simulate-role').value;
    const navItems = document.querySelectorAll('#nav-list li');
    navItems.forEach(item => {
      const itemRole = item.getAttribute('data-role');
      if (itemRole === role || role === 'Admin') {
        item.style.display = 'list-item';
      } else {
        item.style.display = 'none';
      }
    });
  
    const display = document.getElementById('feature-display');
    display.innerHTML = `<p>Visible Features for ${role}:</p><ul>`;
    navItems.forEach(item => {
      if (item.style.display === 'list-item') {
        display.innerHTML += `<li>${item.textContent}</li>`;
      }
    });
    display.innerHTML += '</ul>';
  }
  
  window.onload = function() {
    populateUserTable();
    updateVisibleFeatures();
  };
  