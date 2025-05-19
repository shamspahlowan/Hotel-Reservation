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
  <title>Booking | NexStay</title>
  <link rel="stylesheet" href="group-bookings.css" />

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

  <div class="main">
    <h1>Book Your Stay</h1>

    <div class="container">
      <div class="tabs">
        <div class="tab active" onclick="showTab('single-booking')">Single Booking</div>
        <div class="tab" onclick="showTab('group-booking')">Group Booking</div>
      </div>

      <div id="single-booking" class="tab-content active">
        <h2>Single Booking</h2>
        <div class="input-group">
          <label for="single-hotel">Hotel</label>
          <select id="single-hotel">
            <option value="oceanview">Oceanview Resort ($200/night)</option>
            <option value="cityscape">Cityscape Hotel ($150/night)</option>
            <option value="mountainlodge">Mountain Lodge ($180/night)</option>
          </select>
        </div>
        <div class="input-group">
          <label for="single-room">Room Type</label>
          <select id="single-room">
            <option value="standard">Standard ($100/night)</option>
            <option value="deluxe">Deluxe ($150/night)</option>
            <option value="suite">Suite ($200/night)</option>
          </select>
        </div>
        <div class="input-group">
          <label for="single-checkin">Check-in Date</label>
          <input type="date" id="single-checkin" min="2025-05-19" />
        </div>
        <div class="input-group">
          <label for="single-checkout">Check-out Date</label>
          <input type="date" id="single-checkout" />
        </div>
        <button onclick="submitSingleBooking()">Book Now</button>
        <div id="single-result" class="result"></div>
      </div>

      <div id="group-booking" class="tab-content">
        <h2>Group Booking</h2>
        <div class="input-group">
          <label for="group-hotel">Hotel</label>
          <select id="group-hotel">
            <option value="oceanview">Oceanview Resort ($200/night)</option>
            <option value="cityscape">Cityscape Hotel ($150/night)</option>
            <option value="mountainlodge">Mountain Lodge ($180/night)</option>
          </select>
        </div>
        <div class="input-group">
          <label for="group-checkin">Check-in Date</label>
          <input type="date" id="group-checkin" min="2025-05-19" />
        </div>
        <div class="input-group">
          <label for="group-checkout">Check-out Date</label>
          <input type="date" id="group-checkout" />
        </div>
        <div class="input-group">
          <h2>Guests</h2>
          <div id="guest-list"></div>
          <div class="guest-entry">
            <input type="text" id="guest-name" placeholder="Enter guest name" />
            <input type="email" id="guest-email" placeholder="Enter guest email" />
            <button onclick="addGuest()">Add Guest</button>
          </div>
        </div>
        <div class="input-group">
          <h2>Rooms</h2>
          <div class="room-selection">
            <select id="room-type">
              <option value="standard">Standard ($100/night)</option>
              <option value="deluxe">Deluxe ($150/night)</option>
              <option value="suite">Suite ($200/night)</option>
            </select>
            <input type="number" id="room-quantity" placeholder="Quantity" min="1" />
            <button onclick="addRoom()">Add Room</button>
          </div>
          <div id="room-list" class="result"></div>
        </div>
        <div class="input-group">
          <label for="payment-terms">Payment Terms</label>
          <select id="payment-terms">
            <option value="full">Full Payment</option>
            <option value="deposit">50% Deposit</option>
            <option value="split">Split Billing</option>
          </select>
        </div>
        <div class="input-group">
          <label for="event-space">Event Space</label>
          <select id="event-space">
            <option value="none">None</option>
            <option value="conference">Conference Room ($500)</option>
            <option value="banquet">Banquet Hall ($1000)</option>
          </select>
        </div>
        <button onclick="submitGroupBooking()">Book Group Stay</button>
        <div id="group-result" class="result"></div>
      </div>
    </div>
  </div>
<script src="group-bookings.js"></script>
</body>

</html>