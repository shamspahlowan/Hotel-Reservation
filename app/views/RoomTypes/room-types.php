<?php
$filter = $_POST['categorySelect'] ?? '';
$filterError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $filter !== '') {
  $validOptions = ['Standard', 'Deluxe', 'Suite'];
  if (!in_array($filter, $validOptions)) {
    $filterError = 'Invalid room category selected.';
    $filter = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Room Types</title>
  <link rel="stylesheet" href="room-types.css" />
</head>
<body>
  <div class="room-container">
    <h2>Our Room Types</h2>

    <div class="filter-bar">
      <form method="POST" action="">
        <label for="categorySelect">Filter by Category:</label>
        <select id="categorySelect" name="categorySelect">
          <option value="" <?= $filter === '' ? 'selected' : '' ?>>All</option>
          <option value="Standard" <?= $filter === 'Standard' ? 'selected' : '' ?>>Standard</option>
          <option value="Deluxe" <?= $filter === 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
          <option value="Suite" <?= $filter === 'Suite' ? 'selected' : '' ?>>Suite</option>
        </select>
        <button type="submit">Apply</button>
        <?php if ($filterError): ?>
          <p style="color: red; font-size: 0.9rem; text-align: center;"><?= htmlspecialchars($filterError) ?></p>
        <?php endif; ?>
      </form>
    </div>

    <div id="roomList" class="room-list"></div>

    <h3>Compare Amenities</h3>
    <table class="compare-table">
      <thead>
        <tr>
          <th>Amenity</th>
          <th>Standard</th>
          <th>Deluxe</th>
          <th>Suite</th>
        </tr>
      </thead>
      <tbody id="amenitiesTable"></tbody>
    </table>
  </div>

  <!-- 360° Tour Modal -->
  <div id="tourModal" class="modal">
    <div class="modal-content">
      <span onclick="closeModal()" class="close">&times;</span>
      <p><strong>360° Virtual Tour</strong><br/>[Simulated View]</p>
    </div>
  </div>

  <script>
    const rooms = [
      {
        name: "City Comfort",
        category: "Standard",
        image: "../../public/images/standard1.jpg",
        amenities: ["Wi-Fi", "TV", "AC"]
      },
      {
        name: "Seaside Bliss",
        category: "Deluxe",
        image: "../../public/images/deluxe1.jpg",
        amenities: ["Wi-Fi", "TV", "AC", "Mini Fridge"]
      },
      {
        name: "Presidential Suite",
        category: "Suite",
        image: "../../public/images/suite1.jpg",
        amenities: ["Wi-Fi", "TV", "AC", "Jacuzzi", "Balcony"]
      }
    ];

    const filter = "<?= $filter ?>";
    const allAmenities = ["Wi-Fi", "TV", "AC", "Mini Fridge", "Jacuzzi", "Balcony"];

    function renderRooms(filter) {
      const list = document.getElementById("roomList");
      list.innerHTML = "";

      const filtered = filter ? rooms.filter(r => r.category === filter) : rooms;

      filtered.forEach(room => {
        const div = document.createElement("div");
        div.className = "room-card";
        div.innerHTML = `
          <img src="${room.image}" alt="${room.name}" />
          <div>
            <h4>${room.name}</h4>
            <p><strong>Category:</strong> ${room.category}</p>
            <p><strong>Amenities:</strong> ${room.amenities.join(", ")}</p>
            <button onclick="openModal()">View 360° Tour</button>
          </div>
        `;
        list.appendChild(div);
      });
    }

    function renderAmenityComparison() {
      const tbody = document.getElementById("amenitiesTable");
      tbody.innerHTML = "";

      allAmenities.forEach(amenity => {
        const row = document.createElement("tr");
        const cells = [amenity];

        ["Standard", "Deluxe", "Suite"].forEach(cat => {
          const room = rooms.find(r => r.category === cat);
          const hasAmenity = room?.amenities.includes(amenity);
          cells.push(hasAmenity ? "✔️" : "❌");
        });

        row.innerHTML = cells.map(cell => `<td>${cell}</td>`).join("");
        tbody.appendChild(row);
      });
    }

    function openModal() {
      document.getElementById("tourModal").style.display = "flex";
    }

    function closeModal() {
      document.getElementById("tourModal").style.display = "none";
    }

    renderRooms(filter);
    renderAmenityComparison();
  </script>
   <script src="room-types.js"></script>
</body>
</html>