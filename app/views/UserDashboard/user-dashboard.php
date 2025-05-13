<!-- File: user-dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../../views/authentication/login.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'Shams');
$userPoints = intval($_SESSION['points'] ?? 0);
$userAvatar = $_SESSION['avatar'] ?? 'default-avatar.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Dashboard</title>
  <style>
    /* Reset & Base */
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family: Arial, sans-serif; background: #f5f7fa; color: #333; }
    a { text-decoration: none; color: inherit; }

    /* Navbar */
    .navbar { background: #004aad; padding: 0.75rem 2rem; display: flex; justify-content: space-between; align-items: center; }
    .nav-brand { color: #fff; font-size: 1.5rem; font-weight: bold; }
    .nav-profile { display: flex; align-items: center; gap: 0.75rem; }
    .nav-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
    .nav-profile .info { color: #fff; line-height: 1.2; }
    .nav-profile .info .name { font-weight: bold; }
    .nav-profile .info .points { font-size: 0.9rem; opacity: 0.85; }

    /* Main Links Section */
    .links-container { max-width: 900px; margin: 2rem auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
    .link-card { background: #fff; border-radius: 8px; padding: 1.5rem; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1); transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .link-card:hover { transform: translateY(-4px); box-shadow: 0 4px 12px rgba(0,0,0,0.12); }
    .link-card .icon { font-size: 2rem; margin-bottom: 0.75rem; color: #004aad; }
    .link-card span { display: block; font-size: 1rem; font-weight: bold; color: #004aad; }

    /* Footer */
    .footer { text-align: center; margin: 3rem 0 1rem; font-size: 0.85rem; color: #777; }
  </style>
</head>
<body>
  <header class="navbar">
    <div class="nav-brand">NexStay</div>
    <div class="nav-profile">
      <img src="<?= $userAvatar ?>" alt="Profile Picture" />
      <div class="info">
        <div class="name"><?= $username ?></div>
        <div class="points"><?= $userPoints ?> Points</div>
      </div>
      <button onclick="window.location.href='../../controllers/authentication/logout.php'" style="background:#ff6b6b;border:none;color:#fff;padding:0.5rem 1rem;border-radius:6px;cursor:pointer;">Logout</button>
    </div>
  </header>

  <main class="links-container">
    <div class="link-card" onclick="window.location.href='../../views/guest-profile/guest-profile.html'">
      <div class="icon">👤</div>
      <span>Guest Profile</span>
    </div>
    <div class="link-card" onclick="window.location.href='../../views/profileManagement/profile.php'">
      <div class="icon">✏️</div>
      <span>Edit Profile</span>
    </div>
    <div class="link-card" onclick="window.location.href='../../views/GroupBookings/group-bookings.php'">
      <div class="icon">🧑‍🤝‍🧑</div>
      <span>Group Booking</span>
    </div>
    <div class="link-card" onclick="window.location.href='../../views/ContactUs/contact.php'">
      <div class="icon">✉️</div>
      <span>Contact Us</span>
    </div>
    <div class="link-card" onclick="window.location.href='../../views/Cancellation/cancellation-policy.php'">
      <div class="icon">🚫</div>
      <span>Cancellation</span>
    </div>
    <div class="link-card" onclick="window.location.href='../../views/Search&Filter/search.php'">
      <div class="icon">🔍</div>
      <span>Search & Filter</span>
    </div>
  </main>

  <footer class="footer">
    &copy; <?= date('Y') ?> NexStay. All rights reserved.
  </footer>
</body>
</html>
