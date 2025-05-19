<?php
$error = '';
$success = '';

// No server POST processing for export, but validation could go here if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Data Export - NexStay</title>
  <link rel="stylesheet" href="data-export.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
  <div class="export-container">
    <h2>Export Booking Data</h2>

    <div class="filters">
      <label>From: <input type="date" id="startDate" /></label>
      <label>To: <input type="date" id="endDate" /></label>
    </div>

    <div class="buttons">
      <button onclick="exportCSV()">Export CSV</button>
      <button onclick="exportPDF()">Export PDF</button>
    </div>

    <div class="table-container">
      <table id="dataTable">
        <thead>
          <tr>
            <th>Guest</th>
            <th>Room</th>
            <th>Date</th>
            <th>Amount ($)</th>
          </tr>
        </thead>
        <tbody id="tableBody"></tbody>
      </table>
    </div>
  </div>
  <script src="data-export.js"></script>
</body>
</html>