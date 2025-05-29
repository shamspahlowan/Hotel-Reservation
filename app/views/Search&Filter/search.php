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
    <title>Search Rooms | NexStay</title>
    <link rel="stylesheet" href="search.css" />
</head>
<body>
    <div class="search-container">
        <h2>Find Your Perfect Room</h2>
        
        <div class="search-details" id="search-details"></div>
        
        <div class="search-form">
            <input type="text" id="searchInput" placeholder="Search by hotel name, city, or room type..." />
            
            <div class="filters">
                <select id="roomType">
                    <option value="">All Room Types</option>
                    <option value="Single">Single Room</option>
                    <option value="Double">Double Room</option>
                    <option value="Suite">Suite</option>
                    <option value="Deluxe">Deluxe</option>
                </select>
                
                <select id="priceRange">
                    <option value="">All Prices</option>
                    <option value="0-50">Under $50</option>
                    <option value="50-100">$50 - $100</option>
                    <option value="100-200">$100 - $200</option>
                    <option value="200-9999">Above $200</option>
                </select>
                
                <label><input type="checkbox" id="wifi" /> Wi-Fi</label>
                <label><input type="checkbox" id="ac" /> Air Conditioning</label>
            </div>
        </div>
        
        <div id="loading" class="loading" style="display: none;">
            <p>Loading available rooms...</p>
        </div>
        
        <div id="results" class="results"></div>
    </div>

    <script src="search.js"></script>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const params = new URLSearchParams(window.location.search);
            const checkin = params.get("checkin") || "Not specified";
            const checkout = params.get("checkout") || "Not specified";
            const guests = params.get("guests") || "Not specified";
            
            document.getElementById("search-details").innerHTML = `
                <p><strong>Check In:</strong> ${checkin}</p>
                <p><strong>Check Out:</strong> ${checkout}</p>
                <p><strong>Guests:</strong> ${guests}</p>
            `;
        });
    </script> -->
</body>
</html>