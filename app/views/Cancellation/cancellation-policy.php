
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
  <title>Cancellation Policy | NexStay</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h1>Cancellation Policy</h1>

    <div class="section">
      <h2>View Policy by Rate Type</h2>
      <select id="rateSelect" onchange="displayPolicy()">
        <option value="standard">Standard Rate</option>
        <option value="nonrefundable">Non-Refundable</option>
        <option value="peak">Peak Season Rate</option>
      </select>
      <div id="policyText" class="result"></div>
    </div>

    <div class="section">
      <h2>Manage Booking</h2>
      <div class="input-group">
        <label for="bookingId">Booking ID</label>
        <input type="text" id="bookingId" placeholder="Enter booking ID" />
      </div>
      <button onclick="processBooking()">View Cancellation Details</button>
      <div id="bookingResult" class="result"></div>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>

