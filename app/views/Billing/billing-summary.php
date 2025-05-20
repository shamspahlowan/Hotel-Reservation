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
  <title>Billing | NexStay</title>
  <link rel="stylesheet" href="billing-summary.css">
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
    <h1>Billing</h1>

    <div id="access-message" class="container"></div>

    <div id="billing-content" style="display: none;">
      <div class="container">
        <h2>Folio Viewer</h2>
        <div class="input-group">
          <label for="booking-id">Select Booking</label>
          <select id="booking-id" onchange="displayFolio()">
            <option value="">Select a booking</option>
          </select>
        </div>
        <div id="folio-details" class="result"></div>
      </div>

      <div class="container">
        <h2>Charge Breakdown</h2>
        <table id="charge-table">
          <thead>
            <tr>
              <th>Category</th>
              <th>Date</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <div id="charge-total" class="result"></div>
      </div>

      <div id="split-payments" class="container" style="display: none;">
        <h2>Split Payments</h2>
        <div id="split-list"></div>
        <div class="split-entry">
          <select id="split-type">
            <option value="even">Split Evenly</option>
            <option value="custom">Custom Amounts</option>
          </select>
          <button onclick="setupSplitPayments()">Apply Split</button>
        </div>
        <div id="split-result" class="result"></div>
      </div>

      <div class="container">
        <h2>Receipt</h2>
        <button onclick="generateReceipt()">Generate Receipt</button>
        <div id="receipt-output" class="receipt"></div>
      </div>
    </div>
  </div>

  <script src="billing-summary.js"></script>
</body>
</html>