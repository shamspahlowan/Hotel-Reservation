// Data for Users and Content (Simulating Backend Data)
const users = [
    { id: 1, name: 'Olivia Brown', email: 'olivia@example.com', status: 'Active' },
    { id: 2, name: 'Raj Patel', email: 'raj@example.com', status: 'Inactive' },
    { id: 3, name: 'Laura Smith', email: 'laura@example.com', status: 'Active' },
    { id: 4, name: 'James White', email: 'james@example.com', status: 'Inactive' }
  ];
  
  const content = [
    { id: 1, title: 'Room Booking', status: 'Published' },
    { id: 2, title: 'Analytics Overview', status: 'Draft' },
    { id: 3, title: 'User Dashboard', status: 'Published' },
    { id: 4, title: 'Pricing Page', status: 'Published' }
  ];
  
  // Dynamically populate the tables
  function populateUserTable() {
    const tableBody = document.querySelector('#user-table tbody');
    tableBody.innerHTML = '';
    
    users.forEach(user => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="checkbox" class="user-checkbox" data-id="${user.id}" /></td>
        <td>${user.name}</td>
        <td>${user.email}</td>
        <td>${user.status}</td>
        <td><button onclick="editUser(${user.id})">Edit</button></td>
      `;
      tableBody.appendChild(row);
    });
  }
  
  function populateContentTable() {
    const tableBody = document.querySelector('#content-table tbody');
    tableBody.innerHTML = '';
    
    content.forEach(item => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="checkbox" class="content-checkbox" data-id="${item.id}" /></td>
        <td>${item.title}</td>
        <td>${item.status}</td>
        <td><button onclick="editContent(${item.id})">Edit</button></td>
      `;
      tableBody.appendChild(row);
    });
  }
  
  // Filtering functions
  function filterUsers() {
    const query = document.getElementById('user-search').value.toLowerCase();
    const filteredUsers = users.filter(user => user.name.toLowerCase().includes(query));
    users.length = 0;
    users.push(...filteredUsers);
    populateUserTable();
  }
  
  function filterContent() {
    const query = document.getElementById('content-search').value.toLowerCase();
    const filteredContent = content.filter(item => item.title.toLowerCase().includes(query));
    content.length = 0;
    content.push(...filteredContent);
    populateContentTable();
  }
  
  // Toggle select all users
  function toggleSelectAllUsers() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = document.getElementById('select-all-users').checked;
    });
  }
  
  // Bulk actions for users
  function bulkDeleteUsers() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'));
    const userIds = selectedUsers.map(checkbox => parseInt(checkbox.getAttribute('data-id')));
    console.log('Deleting users with IDs:', userIds);
    // Simulate deletion
    users.filter(user => !userIds.includes(user.id));
    populateUserTable();
  }
  
  function bulkActivateUsers() {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'));
    const userIds = selectedUsers.map(checkbox => parseInt(checkbox.getAttribute('data-id')));
    console.log('Activating users with IDs:', userIds);
    // Simulate activation
    users.forEach(user => {
      if (userIds.includes(user.id)) {
        user.status = 'Active';
      }
    });
    populateUserTable();
  }
  
  // System settings save function
  function saveSystemSettings() {
    const siteName = document.getElementById('site-name').value;
    const maintenanceMode = document.getElementById('maintenance-mode').value;
    console.log('System settings saved:', { siteName, maintenanceMode });
  }
  
  // Initialize page
  document.addEventListener('DOMContentLoaded', () => {
    populateUserTable();
    populateContentTable();
  });
  