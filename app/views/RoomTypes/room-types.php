<?php
// Server-side validation
$filter = isset($_POST['categorySelect']) ? trim($_POST['categorySelect']) : '';
$filterError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $filter !== '') {
    $validOptions = ['Standard', 'Deluxe', 'Suite', ''];
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
            <form method="POST" action="" id="filterForm">
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

    <script>
        const filter = "<?= htmlspecialchars($filter) ?>";
    </script>
    <script src="room-types.js"></script>
</body>
</html>
