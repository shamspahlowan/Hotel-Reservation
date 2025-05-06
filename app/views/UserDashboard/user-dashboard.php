<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard</title>
  <link rel="stylesheet" href="user-dashboard.css" />
</head>
<body>
  <div class="dashboard-container">
    <h1>Welcome to Your Dashboard</h1>

    <div class="button-grid">
      <button onclick="window.location.href ='../../views/guest-profile/guest-profile.html'">Guest Profile</button>
      <button onclick="navigate('../../views/profileManagement/profile.php')">Edit Profile</button>
      <button onclick="navigate('../../views/GroupBookings/group-bookings.php')">Group Booking</button>
      <button onclick="navigate('../../views/ContactUs/contact.php')">Contact Us</button>
      <button onclick="navigate('../../views/Cancellation/cancellation-policy.php')">Cancellation</button>
      <button onclick="navigate('../../views/Search&Filter/search.php')">Search & Filter</button>
    </div>

    <div class="logout">
      <button onclick="window.location.href ='../../controllers/authentication/logout.php'">Logout</button>
    </div>
  </div>

  <!-- <script src="user-dashboard.js"></script> -->
</body>
</html>
