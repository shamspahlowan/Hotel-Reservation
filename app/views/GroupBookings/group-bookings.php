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
  <meta charset="UTF-8">
  <title>Group Bookings</title>
</head>
<body>
  <section id="group-manager">
    <h2>Group Manager</h2>
    <button id="new-group-btn">New Group Booking</button>
    <ul id="groups-list"></ul>
  </section>

  <section id="room-block-tool">
    <h2>Room Block Tool</h2>
    <form id="room-block-form" novalidate>
      <div class="form-group">
        <label for="group-id">Group ID:</label>
        <input type="text" id="group-id" name="groupId" required />
      </div>
      <div class="form-group">
        <label for="num-rooms"># of Rooms:</label>
        <input type="number" id="num-rooms" name="numRooms" min="1" required />
      </div>
      <div class="form-group">
        <label for="room-type">Room Type:</label>
        <select id="room-type" name="roomType">
          <option value="single">Single</option>
          <option value="double">Double</option>
          <option value="suite">Suite</option>
        </select>
      </div>
      <button type="submit">Block Rooms</button>
    </form>
  </section>

  <section id="payment-terms">
    <h2>Payment Terms</h2>
    <form id="terms-form" novalidate>
      <div class="form-group">
        <label for="deposit-rate">Deposit Rate (%):</label>
        <input type="number" id="deposit-rate" name="depositRate" min="0" max="100" required />
      </div>
      <div class="form-group">
        <label for="due-date">Final Payment Due:</label>
        <input type="date" id="due-date" name="dueDate" required />
      </div>
      <button type="submit">Set Terms</button>
    </form>
  </section>

  <section id="event-planner">
    <h2>Event Planner</h2>
    <form id="event-form" novalidate>
      <div class="form-group">
        <label for="event-name">Event Name:</label>
        <input type="text" id="event-name" name="eventName" required />
      </div>
      <div class="form-group">
        <label for="event-date">Event Date:</label>
        <input type="date" id="event-date" name="eventDate" required />
      </div>
      <div class="form-group">
        <label for="space-type">Space Type:</label>
        <select id="space-type" name="spaceType">
          <option value="conference">Conference Room</option>
          <option value="banquet">Banquet Hall</option>
          <option value="outdoor">Outdoor Area</option>
        </select>
      </div>
      <button type="submit">Plan Event</button>
    </form>
  </section>

  <script src="group-bookings.js"></script>
</body>
</html>