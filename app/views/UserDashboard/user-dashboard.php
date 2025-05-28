<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}
require_once('../../models/UserModel.php');
require_once('../../models/LoyaltyModel.php');

$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);
$userPoints = function_exists('getUserPoints') ? getUserPoints($user_id) : 0;
$userAvatar = $user['avatar'] ?? 'defaultProfileImage.png';
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
      <img src="../../<?php echo $user['avatar']; ?>">
      <div class="info">
        <div class="name"><?php echo htmlspecialchars($user['username']); ?></div>
        <div class="points"><?php echo intval($userPoints); ?> Points</div>
      </div>
      <button onclick="window.location.href='../../controllers/authentication/logout.php'">Logout</button>
    </div>
  </header>

  <div class="content">
    <div class="sidebar">
      <h2>Menu</h2>
      <!-- <div class="link-card" onclick="window.location.href='../../views/guest-profile/guest-profile.php'">
        <div class="icon">👤</div>
        <span>Profile</span>
      </div> -->
      <div class="link-card" onclick="window.location.href='../../views/profileManagement/profile.php'">
        <div class="icon">✏️</div>
        <span>Edit Profile</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/GroupBookings/group-bookings.php'">
        <div class="icon">🧑‍🤝‍🧑</div>
        <span>Booking</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/ContactUs/contact.php'">
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
      <div class="link-card" id="conciergeBtn" style="display:none;" onclick="window.location.href='../../views/ConciergeRequest/concierge-requests.php'">
        <div class="icon">🛎️</div>
        <span>Concierge Requests</span>
      </div>
      <div class="link-card" onclick="window.location.href='../../views/Billing/billing-summary.php'">
        <div class="icon">💳</div>
        <span>Billing Summary</span>
      </div>
    </div>

    <div class="main">
      <h1>User Dashboard</h1>
      <div class="container">
        <div class="section">
          <h2>Current Stay</h2>
          <div id="currentStay" class="result">Loading...</div>
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
            <tbody>
              <tr><td colspan="6">Loading...</td></tr>
            </tbody>
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