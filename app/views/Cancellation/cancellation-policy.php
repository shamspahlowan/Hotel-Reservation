
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cancellation Policy</title>
  <link rel="stylesheet" href="cancellation-policy.css">
</head>
<body>
  <div class="container">
    <!-- Policy Display -->
    <section id="terms-display" class="section">
      <h2>Cancellation Terms</h2>
      <label for="rate-type">Rate Type:</label>
      <select id="rate-type" aria-describedby="terms-text">
        <option value="">-- Choose Rate Type --</option>
        <option value="standard">Standard</option>
        <option value="flexible">Flexible</option>
        <option value="nonrefundable">Non‑Refundable</option>
      </select>
      <p id="terms-text" class="info-text"></p>
    </section>

    <!-- Booking Modification -->
    <section id="modification-flow" class="section">
      <h2>Modify Existing Booking</h2>
      <form id="modify-form" novalidate>
        <div class="form-group">
          <label for="booking-id">Booking ID:</label>
          <input type="text" id="booking-id" name="bookingId" placeholder="e.g. ABC123" required />
        </div>
        <div class="form-group">
          <label for="new-date">New Check‑In Date:</label>
          <input type="date" id="new-date" name="newDate" required />
        </div>
        <button type="submit" class="btn">Request Change</button>
      </form>
    </section>

    <!-- Penalty Calculator -->
    <section id="penalty-calculator" class="section">
      <h2>Cancellation Fee Calculator</h2>
      <form id="penalty-form" novalidate>
        <div class="form-group">
          <label for="checkin-date">Scheduled Check‑In:</label>
          <input type="date" id="checkin-date" name="checkinDate" required />
        </div>
        <div class="form-group">
          <label for="cancel-date">Cancellation Date:</label>
          <input type="date" id="cancel-date" name="cancelDate" required />
        </div>
        <div class="form-group">
          <label for="penalty-rate-type">Rate Type:</label>
          <select id="penalty-rate-type" required>
            <option value="">-- Select --</option>
            <option value="standard">Standard</option>
            <option value="flexible">Flexible</option>
            <option value="nonrefundable">Non‑Refundable</option>
          </select>
        </div>
        <button type="button" id="calculate-button" class="btn">Calculate Fee</button>
      </form>
      <p id="fee-result" class="result-text"></p>
    </section>
  </div>

  <script src="cancellation-policy.js"></script>
</body>
</html>
