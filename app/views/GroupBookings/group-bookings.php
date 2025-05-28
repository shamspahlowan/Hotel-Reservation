<?php
// filepath: c:\xampp\htdocs\Hotel-Reservation\app\views\GroupBookings\group-bookings.php
session_start();
if (!isset($_SESSION['status'])) {
  header("Location: ../../views/authentication/login2.php");
  exit;
}

// Get user info for display
$username = $_SESSION['username'] ?? 'Guest';
$user_id = $_SESSION['user_id'] ?? 0;
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
      <img src="../../assets/images/default-avatar.png" alt="Profile Picture" />
      <div class="info">
        <div class="name"><?php echo htmlspecialchars($username); ?></div>
        <div class="points">Welcome Back!</div>
      </div>
      <button onclick="window.location.href='../../controllers/AuthController.php?action=logout'">Logout</button>
    </div>
  </header>

  <div class="main">
    <h1>Book Your Stay</h1>

    <div class="container">
      <div class="tabs">
        <div class="tab active" onclick="showTab('single-booking')">Single Booking</div>
        <div class="tab" onclick="showTab('group-booking')">Group Booking</div>
      </div>

      <!-- Loading indicator -->
      <div id="loading" class="loading" style="display: none;">
        <p>Loading hotels and rooms...</p>
      </div>

      <div id="single-booking" class="tab-content active">
        <h2>Single Room Booking</h2>
        
        <div class="input-group">
          <label for="single-hotel">Select Hotel *</label>
          <select id="single-hotel" required>
            <option value="">Loading hotels...</option>
          </select>
        </div>
        
        <div class="input-group">
          <label for="single-room">Room Type *</label>
          <select id="single-room" required>
            <option value="">First select a hotel</option>
          </select>
        </div>
        
        <div class="date-row">
          <div class="input-group">
            <label for="single-checkin">Check-in Date *</label>
            <input type="date" id="single-checkin" required />
          </div>
          <div class="input-group">
            <label for="single-checkout">Check-out Date *</label>
            <input type="date" id="single-checkout" required />
          </div>
        </div>
        
        <div class="input-group">
          <label for="single-guests">Number of Guests</label>
          <select id="single-guests">
            <option value="1">1 Guest</option>
            <option value="2">2 Guests</option>
            <option value="3">3 Guests</option>
            <option value="4">4 Guests</option>
          </select>
        </div>
        
        <div class="input-group">
          <label for="single-requests">Special Requests (Optional)</label>
          <textarea id="single-requests" placeholder="Any special requirements or preferences..." rows="3"></textarea>
        </div>
        
        <button onclick="submitSingleBooking()" class="book-btn">Book Now</button>
        <div id="single-result" class="result"></div>
      </div>

      <div id="group-booking" class="tab-content">
        <h2>Group Booking</h2>
        
        <div class="input-group">
          <label for="group-hotel">Select Hotel *</label>
          <select id="group-hotel" required>
            <option value="">Loading hotels...</option>
          </select>
        </div>
        
        <div class="date-row">
          <div class="input-group">
            <label for="group-checkin">Check-in Date *</label>
            <input type="date" id="group-checkin" required />
          </div>
          <div class="input-group">
            <label for="group-checkout">Check-out Date *</label>
            <input type="date" id="group-checkout" required />
          </div>
        </div>

        <!-- Guest Management Section -->
        <div class="input-group">
          <h3>Guest Information</h3>
          <div class="guest-form">
            <input type="text" id="guest-name" placeholder="Guest Name *" />
            <input type="email" id="guest-email" placeholder="Guest Email *" />
            <button onclick="addGuest()" type="button">Add Guest</button>
          </div>
          <div id="guest-list" class="guest-list">
            <p class="helper-text">No guests added yet. Add at least one guest to proceed.</p>
          </div>
        </div>

        <!-- Room Selection Section -->
        <div class="input-group">
          <h3>Room Selection</h3>
          <div class="room-form">
            <select id="room-type">
              <option value="">First select a hotel</option>
            </select>
            <input type="number" id="room-quantity" placeholder="Quantity" min="1" max="10" />
            <button onclick="addRoom()" type="button">Add Rooms</button>
          </div>
          <div id="room-list" class="room-list">
            <p class="helper-text">No rooms selected yet. Select rooms for your group.</p>
          </div>
        </div>

        <!-- Booking Options -->
        <div class="booking-options">
          <div class="input-group">
            <label for="payment-terms">Payment Terms</label>
            <select id="payment-terms">
              <option value="full">Full Payment (Pay all now)</option>
              <option value="deposit">50% Deposit (Pay 50% now, 50% at check-in)</option>
              <option value="split">Split Billing (Individual guest payments)</option>
            </select>
          </div>
          
          <div class="input-group">
            <label for="event-space">Event Space</label>
            <select id="event-space">
              <option value="none">No Event Space</option>
              <option value="conference">Conference Room (+$500)</option>
              <option value="banquet">Banquet Hall (+$1000)</option>
            </select>
          </div>
        </div>
        
        <div class="input-group">
          <label for="group-requests">Special Requests (Optional)</label>
          <textarea id="group-requests" placeholder="Any special requirements for the group..." rows="3"></textarea>
        </div>
        
        <button onclick="submitGroupBooking()" class="book-btn">Book Group Stay</button>
        <div id="group-result" class="result"></div>
      </div>
    </div>
  </div>

  <!-- Success Modal (Optional) -->
  <div id="success-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Booking Confirmed!</h2>
      <div id="modal-body"></div>
    </div>
  </div>

  <script src="group-bookings.js"></script>
  <script>
    // Pass user data to JavaScript
    window.userData = {
      userId: <?php echo $user_id; ?>,
      username: '<?php echo htmlspecialchars($username); ?>'
    };
  </script>
</body>

</html>