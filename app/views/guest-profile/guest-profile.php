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
  <title>Guest Profile - NexStay</title>
  <link rel="stylesheet" href="guest-profile.css" />
</head>
<body>
  <div class="profile-container">
    <h2>Guest Profile</h2>

    <section>
      <h3>Room Preferences</h3>
      <form id="preferencesForm">
        <label>Bed Type:
          <select id="bedType">
            <option value="Queen">Queen</option>
            <option value="King">King</option>
            <option value="Twin">Twin</option>
          </select>
        </label>

        <label>Preferred Floor:
          <input type="number" id="floor" min="1" max="10" />
        </label>

        <label>View Preference:
          <select id="view">
            <option value="Sea">Sea</option>
            <option value="Garden">Garden</option>
            <option value="City">City</option>
          </select>
        </label>

        <button type="submit">Save Preferences</button>
        <p id="saveMsg"></p>
      </form>
    </section>

    <section>
      <h3>Stay History</h3>
      <table>
        <thead>
          <tr><th>Room</th><th>Dates</th><th>Amount</th></tr>
        </thead>
        <tbody id="historyTable"></tbody>
      </table>
    </section>

    <section>
      <h3>Loyalty Dashboard</h3>
      <p><strong>Total Points:</strong> <span id="points">0</span></p>
      <p><strong>Tier:</strong> <span id="tier">Bronze</span></p>
    </section>
  </div>

  <script src="guest-profile.js"></script>
</body>
</html>