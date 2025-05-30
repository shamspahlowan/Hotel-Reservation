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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Concierge Requests | NexStay</title>
    <link rel="stylesheet" href="concierge-requests.css" />
  </head>
  <body>
    <!-- <header class="navbar">
      <div class="nav-brand">NexStay</div>
      <div class="nav-profile">
        <img src="default-avatar.png" alt="Profile Picture" />
        <div class="info">
          <div class="name">Shams</div>
          <div class="points">0 Points</div>
        </div>
        <button onclick="window.location.href='logout.html'">Logout</button>
      </div>
    </header> -->

    <div class="main">
      <h1>Concierge Requests</h1>

      <div id="checkin-message" class="container"></div>

      <div id="concierge-content" style="display: none">
        <div id="guest-info" class="container guest-info"></div>

        <div class="container">
          <h2>Service Catalog</h2>
          <div class="service-catalog">
            <div class="service-card">
              <h3>Room Service</h3>
              <p>Order meals, beverages, or amenities for your room.</p>
              <a href="room-service.html">Go to Room Service</a>
            </div>
            <div class="service-card">
              <h3>City Tour</h3>
              <p>Guided tour of local attractions ($50).</p>
              <button onclick="showRequestForm('City Tour', 50)">
                Request
              </button>
            </div>
            <div class="service-card">
              <h3>Dining Reservation</h3>
              <p>Book a table at a local restaurant (Free).</p>
              <button onclick="showRequestForm('Dining Reservation', 0)">
                Request
              </button>
            </div>
            <div class="service-card">
              <h3>Transportation</h3>
              <p>Arrange airport transfers or local travel ($30).</p>
              <button onclick="showRequestForm('Transportation', 30)">
                Request
              </button>
            </div>
          </div>
        </div>

        <div id="request-form" class="container" style="display: none">
          <h2 id="request-title">New Request</h2>
          <div class="input-group">
            <label for="request-service">Service</label>
            <input type="text" id="request-service" readonly />
          </div>
          <div class="input-group">
            <label for="request-time">Preferred Time</label>
            <input
              type="datetime-local"
              id="request-time"
              min="2025-05-19T22:44"
            />
          </div>
          <div class="input-group">
            <label for="request-details">Additional Details</label>
            <textarea
              id="request-details"
              placeholder="E.g., specific restaurant, tour preferences"
            ></textarea>
          </div>
          <button onclick="submitRequest()">Submit Request</button>
          <div id="request-result" class="result"></div>
        </div>

        <div class="container">
          <h2>Request Tracker</h2>
          <div class="filter-group">
            <label for="status-filter">Filter by Status</label>
            <select id="status-filter" onchange="filterRequests()">
              <option value="all">All</option>
              <option value="pending">Pending</option>
              <option value="in-progress">In Progress</option>
              <option value="fulfilled">Fulfilled</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <table id="request-table">
            <thead>
              <tr>
                <th>Service</th>
                <th>Request Date</th>
                <th>Status</th>
                <th>Details</th>
                <th>Fulfillment</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="concierge-requests.js"></script>
  </body>
</html>
