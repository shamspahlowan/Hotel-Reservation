<?php
// filepath: c:\xampp\htdocs\Hotel-Reservation\app\models\SearchModel.php
require_once('db.php');

function searchAvailableRooms($filters) {
    $con = getConnection();
    
    // Base query with hotel information
    $sql = "SELECT r.*, h.name as hotel_name, h.city, h.state, h.address, h.amenities as hotel_amenities,
            h.rating as hotel_rating, h.image as hotel_image,
            (SELECT AVG(rv.rating) FROM reviews rv WHERE rv.room_id = r.id) as room_rating,
            (SELECT COUNT(*) FROM reviews rv WHERE rv.room_id = r.id) as review_count
            FROM rooms r 
            JOIN hotels h ON r.hotel_id = h.id 
            WHERE r.status = 'available' AND h.status = 'active'";
    
    $conditions = [];
    
    // Keyword search (hotel name, city, room type)
    if (!empty($filters['keyword'])) {
        $keyword = mysqli_real_escape_string($con, $filters['keyword']);
        $conditions[] = "(h.name LIKE '%$keyword%' OR h.city LIKE '%$keyword%' OR r.type LIKE '%$keyword%')";
    }
    
    // Room type filter
    if (!empty($filters['room_type'])) {
        $room_type = mysqli_real_escape_string($con, $filters['room_type']);
        $conditions[] = "r.type = '$room_type'";
    }
    
    // Price range filter
    if ($filters['min_price'] > 0) {
        $conditions[] = "r.price >= " . floatval($filters['min_price']);
    }
    if ($filters['max_price'] < 9999) {
        $conditions[] = "r.price <= " . floatval($filters['max_price']);
    }
    
    // Availability check (not booked for selected dates)
    if (!empty($filters['checkin']) && !empty($filters['checkout'])) {
        $checkin = mysqli_real_escape_string($con, $filters['checkin']);
        $checkout = mysqli_real_escape_string($con, $filters['checkout']);
        $conditions[] = "r.id NOT IN (
            SELECT room_id FROM bookings 
            WHERE status IN ('confirmed', 'checked_in') 
            AND ((checkin_date <= '$checkin' AND checkout_date > '$checkin') 
            OR (checkin_date < '$checkout' AND checkout_date >= '$checkout')
            OR (checkin_date >= '$checkin' AND checkout_date <= '$checkout'))
        )";
    }
    
    if (!empty($conditions)) {
        $sql .= " AND " . implode(" AND ", $conditions);
    }
    
    $sql .= " ORDER BY h.rating DESC, r.price ASC";
    
    $result = mysqli_query($con, $sql);
    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
    return $rooms;
}

function getRoomDetails($room_id) {
    $con = getConnection();
    $room_id = intval($room_id);
    
    $sql = "SELECT r.*, h.*, 
            (SELECT AVG(rv.rating) FROM reviews rv WHERE rv.room_id = r.id) as room_rating,
            (SELECT COUNT(*) FROM reviews rv WHERE rv.room_id = r.id) as review_count
            FROM rooms r 
            JOIN hotels h ON r.hotel_id = h.id 
            WHERE r.id = $room_id";
    
    $result = mysqli_query($con, $sql);
    $room = mysqli_fetch_assoc($result);
    
    if ($room) {
        // Get reviews for this room
        $reviews_sql = "SELECT rv.*, u.username FROM reviews rv 
                       JOIN users u ON rv.user_id = u.id 
                       WHERE rv.room_id = $room_id 
                       ORDER BY rv.created_at DESC LIMIT 5";
        $reviews_result = mysqli_query($con, $reviews_sql);
        $reviews = [];
        while ($review = mysqli_fetch_assoc($reviews_result)) {
            $reviews[] = $review;
        }
        $room['reviews'] = $reviews;
    }
    
    return $room;
}

function getHotelRooms($hotel_id) {
    $con = getConnection();
    $hotel_id = intval($hotel_id);
    
    $sql = "SELECT r.*, 
            (SELECT AVG(rv.rating) FROM reviews rv WHERE rv.room_id = r.id) as room_rating,
            (SELECT COUNT(*) FROM reviews rv WHERE rv.room_id = r.id) as review_count
            FROM rooms r 
            WHERE r.hotel_id = $hotel_id AND r.status = 'available'
            ORDER BY r.price ASC";
    
    $result = mysqli_query($con, $sql);
    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
    return $rooms;
}
?>