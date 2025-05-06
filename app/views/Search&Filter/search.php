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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Rooms</title>
  <link rel="stylesheet" href="search.css" />
</head>
<body>
  <div class="search-container">
    <h2>Find a Room</h2>

    <input type="text" id="searchInput" placeholder="Search by name or location..." />

    <div class="filters">
      <select id="roomType">
        <option value="">All Types</option>
        <option value="Single">Single</option>
        <option value="Double">Double</option>
        <option value="Suite">Suite</option>
      </select>

      <select id="priceRange">
        <option value="">All Prices</option>
        <option value="0-100">Below $100</option>
        <option value="100-200">$100 - $200</option>
        <option value="200-9999">Above $200</option>
      </select>

      <label><input type="checkbox" id="wifi" /> Wi-Fi</label>
      <label><input type="checkbox" id="ac" /> AC</label>
    </div>

    <div id="results" class="results"></div>
  </div>

  <script src="search.js"></script>
</body>
</html>
