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
        'occupancyRate' => $occupancy,
        'activeUsers' => $activeUsers
    ];
}
function getTransactions() {
    $con = getConnection();
    $sql = "SELECT p.*, u.username as customer_name 
            FROM payments p 
            LEFT JOIN bookings b ON p.booking_id = b.id 
            LEFT JOIN users u ON b.user_id = u.id 
            ORDER BY p.payment_date DESC";
    $result = mysqli_query($con, $sql);
    $transactions = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $transactions[] = $row;
    }
    return $transactions;
}
function getAnalyticsData() {
    $con = getConnection();
    
    // Occupancy rate
    $occupancyQuery = mysqli_query($con, "SELECT COUNT(*) as booked FROM rooms WHERE status='booked'");
    $totalRoomsQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM rooms");
    
    $booked = mysqli_fetch_assoc($occupancyQuery)['booked'] ?? 0;
    $total = mysqli_fetch_assoc($totalRoomsQuery)['total'] ?? 1;
    $occupancyRate = round(($booked / $total) * 100);
    
    // Revenue streams (placeholder data)
    $revenueStreams = [
        'rooms' => 75,
        'services' => 15,
        'other' => 10
    ];
    
    return [
        'occupancyRate' => $occupancyRate,
        'revenueStreams' => $revenueStreams
    ];
}
?>