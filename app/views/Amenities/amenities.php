<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login2.php");
    exit;
}


$search = $_POST['search'] ?? '';
$searchError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (strlen($search) > 60) {
    $searchError = "Search term is too long.";
    $search = '';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Amenities</title>
  <link rel="stylesheet" href="amenities.css" />
</head>
<body>
  <div class="amenities-container">
    <h2>Hotel Amenities</h2>

    <form method="POST">
      <input type="text" id="searchBox" name="search" placeholder="Search amenities (e.g. spa, gym, pool)..." value="<?= htmlspecialchars($search) ?>" />
      <?php if ($searchError): ?><p class="error-text"><?= htmlspecialchars($searchError) ?></p><?php endif; ?>
    </form>

    <div id="amenityList" class="amenity-list"></div>
  </div>

  <script src="amenities.js"></script>
  <script>
    const initialSearch = "<?= htmlspecialchars($search) ?>";
  </script>
</body>
</html>
