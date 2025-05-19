<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'Shams');
$userPoints = intval($_SESSION['points'] ?? 0);
$userAvatar = $_SESSION['avatar'] ?? 'default-avatar.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard | NexStay</title>
  <link rel="stylesheet" href="user-dashboard.css" />
</head>
<body>
  <header class="navbar">
    <div class="nav-brand">NexStay</div>
    <div class="nav-profile">
      <img src="default-avatar.png" alt="Profile Picture" />
      <div class="info">
        <div class="name">Shams</div>
        <div class="points">0 Points</div>
      </div>
      <button onclick="window.location.href='logout.html'">Logout</button>
    </div>
  </header>

  <div class="content">
    <div class="sidebar">
      <h2>Menu</h2>
      <div class="link-card" onclick="window.location.href='../../views/guest-profile/guest-profile.php'">
        <div class="icon">👤</div>
        <span>Profile</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/profileManagement/profile.php'">
        <div class="icon">✏️</div>
        <span>Edit Profile</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/GroupBookings/group-bookings.php'">
        <div class="icon">🧑‍🤝‍🧑</div>
        <span>Group Booking</span>
      </div>
      <div class="link-card" onclick="window.location.href='contact-us.html'">
        <div class="icon">✉️</div>
        <span>Contact Us</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/Cancellation/cancellation-policy.php'">
        <div class="icon">🚫</div>
        <span>Cancellation</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/Search&Filter/search.php'">
        <div class="icon">🔍</div>
        <span>Search & Filter</span>
      </div>
      <div class="link-card" id="conciergeBtn" style="display: none;" onclick="window.location.href='../../views/ConciergeRequest/concierge-requests.html'">
        <div class="icon">🛎️</div>
        <span>Concierge Requests</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/Billing/billing-summary.html'">
        <div class="icon">💳</div>
        <span>Billing Summary</span>
      </div>
    </div>

    <div class="main">
      <h1>User Dashboard</h1>
      <div class="container">
        <div class="section">
          <h2>Current Stay</h2>
          <div id="currentStay" class="result"></div>
        </div>

        <div class="section">
          <h2>Booking History</h2>
          <table id="bookingHistory">
            <thead>
              <tr>
                <th>Booking ID</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Rate Type</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    © 2025 NexStay. All rights reserved.
  </footer>

  <script src="user-dashboard.js"></script>
</body>
</html>

