<?php
 session_start();
 if (!isset($_SESSION['status'])) {
     header("Location: ../../views/authentication/login2.php");

     exit;
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>NexStay | Hotel Dashboard</title>
  <link rel="stylesheet" href="dashboard.css"/>
</head>
<body>

  <nav id="top-bar">
    <h1>Hotel Reservation System Dashboard</h1>
  </nav>

  <aside id="sidebar">
    <div class="sidebar-header">
      <h2>Shortcuts</h2>
    </div>
    <ul>
      <li onclick="alert('Redirecting to Add Booking')">➕ Add Booking</li>
      <li onclick="alert('Redirecting to Manage Rooms')">🛏 Manage Rooms</li>
      <li onclick="alert('Redirecting to Customer List')">👥 View Customers</li>
      <li onclick="alert('Redirecting to Check-In Status')">📋 Check-In Status</li>
    </ul>
  </aside>

  <main id="dashboard-main">

    <!-- Summary Widgets -->
    <section id="summary-widgets">
      <div class="widget" onclick="showDetail('bookings')">
        <h3>Total Bookings</h3>
        <p id="total-bookings">128</p>
      </div>
      <div class="widget" onclick="showDetail('occupancy')">
        <h3>Occupancy Rate</h3>
        <p id="occupancy-rate">76%</p>
      </div>
      <div class="widget" onclick="showDetail('revenue')">
        <h3>Monthly Revenue</h3>
        <p id="monthly-revenue">$45,200</p>
      </div>
      <div class="widget" onclick="showDetail('cancellations')">
        <h3>Cancellations</h3>
        <p id="cancellations">14</p>
      </div>
    </section>

    <!-- Analytics Overview -->
    <section id="analytics-overview">
      <h2>Analytics Overview</h2>

      <!-- Booking Trends Chart -->
      <div class="chart-box">
        <h3>Booking Trends (7 Days)</h3>
        <div class="bar-chart" id="booking-trend-chart"></div>
      </div>

      <!-- Room Occupancy Chart -->
      <div class="chart-box">
        <h3>Room Occupancy</h3>
        <div class="bar-chart" id="occupancy-chart"></div>
      </div>

      <!-- Revenue Breakdown -->
      <div class="chart-box">
        <h3>Revenue Breakdown</h3>
        <div class="bar-chart" id="revenue-chart"></div>
      </div>
    </section>

    <!-- Detail Panel -->
    <section id="details-panel">
      <h2>Detail View</h2>
      <div id="detail-content">
        <p>Select a summary widget to see details here.</p>
      </div>
    </section>

  </main>

  <script src="dashboard.js"></script>
</body>
</html>
