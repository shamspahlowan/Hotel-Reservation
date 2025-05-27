<?php
require_once('db.php');

function getDashboardStats() {
    $con = getConnection();
    // Total Bookings
    $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM bookings");
    $totalBookings = ($row = mysqli_fetch_assoc($result)) ? $row['cnt'] : 0;
    // Revenue
    $result = mysqli_query($con, "SELECT SUM(amount) as sum FROM payments WHERE status='paid'");
    $totalRevenue = ($row = mysqli_fetch_assoc($result)) ? $row['sum'] : 0;
    // Occupancy
    $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM rooms WHERE status='booked'");
    $bookedRooms = ($row = mysqli_fetch_assoc($result)) ? $row['cnt'] : 0;
    $result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM rooms");
    $totalRooms = ($row = mysqli_fetch_assoc($result)) ? $row['cnt'] : 1;
    $occupancy = round(($bookedRooms / $totalRooms) * 100);
    // Active Users
    $result = mysqli_query($con, "SELECT COUNT(DISTINCT user_id) as cnt FROM bookings WHERE checkin_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)");
    $activeUsers = ($row = mysqli_fetch_assoc($result)) ? $row['cnt'] : 0;
    return [
        'totalBookings' => $totalBookings,
        'totalRevenue' => $totalRevenue,
        'occupancy' => $occupancy,
        'activeUsers' => $activeUsers
    ];
}
?>