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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Room Availability - NexStay</title>
  <link rel="stylesheet" href="availability.css" />
</head>
<body>
  <div class="availability-container">
    <h2>Check Room Availability</h2>

    <div class="date-select">
      <label>Check-in:
        <input type="date" id="checkin" />
      </label>
      <label>Check-out:
        <input type="date" id="checkout" />
      </label>
    </div>

    <div id="summary" class="summary-box"></div>
    <div id="roomList" class="room-list"></div>
  </div>

  <script src="availability.js"></script>
</body>
</html>
