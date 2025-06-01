<?php
session_start();
if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== "true") {
  header("Location: ../../views/authentication/login2.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>NexStay Admin Dashboard</title>
  <link href="admin.css" rel="stylesheet" />
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="logo-container">
      <div class="logo">NexStay</div>
    </div>
    <div class="user-menu">
      <div class="user-profile">
        <div class="user-avatar"><?php echo strtoupper(substr($_SESSION['username'] ?? 'AD', 0, 2)); ?></div>
        <div class="user-name"><?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></div>
      </div>
    </div>
  </header>
  <!-- Sidebar Navigation -->
  <aside class="sidebar">
    <a class="nav-item active" href="#dashboard" onclick="showSection('dashboard')">
      <span>Dashboard</span>
    </a>
    <a class="nav-item" href="#hotels" onclick="showSection('hotels')">
      <span>Hotels & Rooms</span>
    </a>
    <a class="nav-item" href="#bookings" onclick="showSection('bookings')">
      <span>Bookings</span>
    </a>
    <a class="nav-item" href="#transactions" onclick="showSection('transactions')">
      <span>Transactions</span>
    </a>
    <a class="nav-item" href="#users" onclick="showSection('users')">
      <span>Users</span>
    </a>
    <a class="nav-item" href="#roles" onclick="showSection('roles')">
      <span>Roles & Permissions</span>
    </a>
    <div class="nav-section">
      <div class="nav-section-title">Reports</div>
      <a class="nav-item" href="#analytics" onclick="showSection('analytics')">
        <span>Analytics</span>
      </a>
      <a class="nav-item" href="#reports" onclick="showSection('reports')">
        <span>Financial Reports</span>
      </a>
    </div>
    <div class="nav-section">
      <div class="nav-section-title">Settings</div>
      <a class="nav-item" href="#profile" onclick="showSection('profile')">
        <span>Profile</span>
      </a>
      <a class="nav-item" href="#settings" onclick="showSection('settings')">
        <span>System Settings</span>
      </a>
    </div>
  </aside>
  <main class="main-content">
    <section class="content-section active" id="dashboard-section">
      <div class="dashboard-header">
        <h1 class="page-title">Dashboard</h1>
        <div class="actions">
          <!-- <button class="btn btn-outline">Export Report</button> -->
          <button class="btn btn-primary" onclick="addNewHotel()">Add Hotel</button>
        </div>
      </div>
      <div class="card-grid">
        <div class="card stat-card">
          <div class="stat-title">Total Bookings</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>12.5% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Revenue</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>8.2% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Average Occupancy</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>5.3% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Active Users</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>15.7% from last month</span>
          </div>
        </div>
      </div>
      <div class="table-container">
        <div class="table-header">
          <h2 class="table-title">Recent Bookings</h2>
          <button class="btn btn-outline" onclick="showSection('bookings')">View All</button>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Guest</th>
              <th>Hotel</th>
              <th>Check-in</th>
              <th>Check-out</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px;">Loading bookings...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="content-section user-role-section" id="bookings-section">
      <div class="dashboard-header">
        <h1 class="page-title">Booking Management</h1>
        <div class="actions">
          <!-- <button class="btn btn-outline">Filter</button> -->
          <button class="btn btn-primary">Create Booking</button>
        </div>
      </div>
      <div class="card-grid">
        <div class="card stat-card">
          <div class="stat-title">Total Bookings</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">All time</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Confirmed</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">% of total</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Pending</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">% of total</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Canceled</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">% of total</div>
        </div>
      </div>
      <div class="table-container">
        <div class="table-header">
          <h2 class="table-title">All Bookings</h2>
          <div class="search-container">
            <input class="search-input" placeholder="Search bookings..." type="text" />
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Guest</th>
              <th>Hotel</th>
              <th>Check-in</th>
              <th>Check-out</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px;">Loading bookings...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="content-section user-role-section" id="users-section">
      <div class="dashboard-header">
        <h1 class="page-title">User Management</h1>
        <div class="actions">
          <!-- <button class="btn btn-outline">Filter</button> -->
          <button class="btn btn-primary" onclick="showMessage('Add User feature will be implemented soon', 'info')">Add New User</button>
        </div>
      </div>
      <div class="card-grid">
        <div class="card stat-card">
          <div class="stat-title">Total Users</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>15.7% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Active Users</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>8.3% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Staff Users</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>2 new this month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">New Registrations</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>This month</span>
          </div>
        </div>
      </div>
      <div class="table-container">
        <div class="table-header">
          <h2 class="table-title">All Users</h2>
          <div class="search-container">
            <input class="search-input" placeholder="Search users..." type="text" />
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Joined</th>
              <th>Last Login</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px;">Loading users...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="content-section user-role-section" id="transactions-section">
      <div class="dashboard-header">
        <h1 class="page-title">Transaction Management</h1>
        <div class="actions">
          <!-- <button class="btn btn-outline">Export CSV</button>
          <button class="btn btn-primary">Filter</button> -->
        </div>
      </div>
      <div class="card-grid">
        <div class="card stat-card">
          <div class="stat-title">Total Revenue</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>8.2% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">This Month</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>12.4% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Refunds</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change negative">
            <span>3.5% from last month</span>
          </div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Avg Transaction</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">
            <span>5.8% from last month</span>
          </div>
        </div>
      </div>
      <div class="table-container">
        <div class="table-header">
          <h2 class="table-title">Recent Transactions</h2>
          <div class="search-container">
            <input class="search-input" placeholder="Search transactions..." type="text" />
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Booking ID</th>
              <th>Customer</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Payment Method</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="8" style="text-align: center; padding: 20px;">Loading transactions...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="content-section user-role-section" id="analytics-section">
      <div class="dashboard-header">
        <h1 class="page-title">Analytics & Reports</h1>
        <div class="actions">
          <!-- <button class="btn btn-outline">Export Report</button>
          <button class="btn btn-primary">Date Range</button> -->
        </div>
      </div>
      <div class="card-grid">
        <div class="card">
          <div class="stat-title">Occupancy Rate</div>
          <div class="chart-container" style="height: 200px; display: flex; align-items: center; justify-content: center;">
            <div style="text-align: center">
              <div style="font-size: 48px; font-weight: 600; color: var(--brand-color);">
                Loading...
              </div>
              <div style="color: var(--apple-success); display: flex; align-items: center; justify-content: center; gap: 4px;">
                <span>5.3% from last month</span>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="stat-title">Revenue Streams</div>
          <div class="chart-container" style="height: 200px; display: flex; align-items: center; justify-content: center;">
            <div style="text-align: center; width: 100%">
              <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <div>Room Bookings</div>
                <div>Loading...</div>
              </div>
              <div style="width: 100%; height: 10px; background-color: #eee; border-radius: 5px; margin-bottom: 15px;">
                <div style="width: 0%; height: 10px; background-color: var(--brand-color); border-radius: 5px;"></div>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <div>Additional Services</div>
                <div>Loading...</div>
              </div>
              <div style="width: 100%; height: 10px; background-color: #eee; border-radius: 5px; margin-bottom: 15px;">
                <div style="width: 0%; height: 10px; background-color: var(--brand-color); border-radius: 5px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="content-section user-role-section" id="hotels-section">
      <div class="dashboard-header">
        <h1 class="page-title">Hotel & Room Management</h1>
        <div class="actions">
          <button class="btn btn-outline">Filter</button>
          <button class="btn btn-primary" onclick="addNewHotel()">Add New Hotel</button>
        </div>
      </div>
      <div class="card-grid">
        <div class="card stat-card">
          <div class="stat-title">Total Hotels</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">All properties</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Active Hotels</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">Currently operational</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Total Rooms</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">Across all hotels</div>
        </div>
        <div class="card stat-card">
          <div class="stat-title">Avg Rating</div>
          <div class="stat-value">Loading...</div>
          <div class="stat-change">Customer satisfaction</div>
        </div>
      </div>
      <div class="table-container">
        <div class="table-header">
          <h2 class="table-title">Manage Hotels</h2>
          <div class="search-container">
            <input class="search-input" placeholder="Search hotels..." type="text" />
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>Hotel ID</th>
              <th>Hotel Name</th>
              <th>Location</th>
              <th>Rooms</th>
              <th>Avg. Rating</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="7" style="text-align: center; padding: 20px;">Loading hotels...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <section class="content-section user-role-section" id="roles-section">
      <div class="dashboard-header">
        <h1 class="page-title">Roles & Permissions</h1>
        <div class="actions">
          <button class="btn btn-primary">Add New Role</button>
        </div>
      </div>
      <div class="role-card">
        <div class="role-header">
          <div class="role-name">Admin</div>
          <div class="role-actions">
            <button class="btn btn-outline">Edit Role</button>
          </div>
        </div>
        <div class="permissions-grid">
          <div class="permission-group">
            <h3 class="permission-group-title">Hotel Management</h3>
            <div class="permission-item">
              <label class="checkbox-container">
                Add/Edit Hotels
                <input checked type="checkbox" />
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="permission-item">
              <label class="checkbox-container">
                Delete Hotels
                <input checked type="checkbox" />
                <span class="checkmark"></span>
              </label>
            </div>
          </div>
          <div class="permission-group">
            <h3 class="permission-group-title">Booking Management</h3>
            <div class="permission-item">
              <label class="checkbox-container">
                View Bookings
                <input checked type="checkbox" />
                <span class="checkmark"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="role-card">
        <div class="role-header">
          <div class="role-name">Guest</div>
          <div class="role-actions">
            <button class="btn btn-outline">Edit Role</button>
          </div>
        </div>
        <div class="permissions-grid">
          <div class="permission-group">
            <h3 class="permission-group-title">Hotel Access</h3>
            <div class="permission-item">
              <label class="checkbox-container">
                Search Hotels
                <input checked type="checkbox" />
                <span class="checkmark"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content-section user-role-section" id="profile-section">
      <div class="dashboard-header">
        <h1 class="page-title">Profile</h1>
      </div>
      <div class="card">
        <p>Sorr, Profile settings service will be available soon.</p>
      </div>
    </section>
    <section class="content-section user-role-section" id="settings-section">
      <div class="dashboard-header">
        <h1 class="page-title">System Settings</h1>
      </div>
      <div class="card">
        <p>Sorry, System settings will be available soon.</p>
      </div>
    </section>
    <section class="content-section user-role-section" id="reports-section">
      <div class="dashboard-header">
        <h1 class="page-title">Financial Reports</h1>
      </div>
      <div class="card">
        <p>Sorry, Financial service will be available soon.</p>
      </div>
    </section>
  </main>
  <script src="admin.js"></script>
</body>

</html>