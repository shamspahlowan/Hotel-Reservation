\<?php
session_start();

$reportMsg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room = trim($_POST['issueRoom'] ?? '');
    $desc = trim($_POST['issueDesc'] ?? '');

    if ($room === '' || $desc === '') {
        $reportMsg = "<span style='color: red;'>All fields are required.</span>";
    } elseif (!is_numeric($room) || $room < 1) {
        $reportMsg = "<span style='color: red;'>Room number must be a valid positive number.</span>";
    } else {
        
        $reportMsg = "<span style='color: green;'>Issue submitted for room $room.</span>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Housekeeping Dashboard</title>
  <link rel="stylesheet" href="housekeeping.css" />
</head>
<body>
  <div class="housekeeping-container">
    <h2>Housekeeping Status Board</h2>

    <div id="roomBoard" class="room-board"></div>

    <h3>Report Maintenance Issue</h3>
    <form id="reportForm" method="POST" action="">
      <label>Room Number:
        <input type="number" name="issueRoom" id="issueRoom" required value="<?= htmlspecialchars($_POST['issueRoom'] ?? '') ?>" />
      </label>
      <label>Issue Description:
        <textarea name="issueDesc" id="issueDesc" required><?= htmlspecialchars($_POST['issueDesc'] ?? '') ?></textarea>
      </label>
      <button type="submit">Submit Report</button>
      <p id="reportMsg"><?= $reportMsg ?></p>
    </form>
  </div>

  <script src="housekeeping.js"></script>
</body>
</html>
