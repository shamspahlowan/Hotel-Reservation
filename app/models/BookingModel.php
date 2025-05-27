<?php
require_once('db.php');

function getAllBookings() {
    $con = getConnection();
    $sql = "SELECT * FROM bookings";
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) $bookings[] = $row;
    return $bookings;
}

function getBookingById($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM bookings WHERE id=$id LIMIT 1";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addBooking($booking) {
    $con = getConnection();
    $user_id = intval($booking['user_id']);
    $room_id = intval($booking['room_id']);
    $checkin = mysqli_real_escape_string($con, $booking['checkin_date']);
    $checkout = mysqli_real_escape_string($con, $booking['checkout_date']);
    $status = mysqli_real_escape_string($con, $booking['status']);
    $sql = "INSERT INTO bookings (user_id, room_id, checkin_date, checkout_date, status, created_at)
            VALUES ($user_id, $room_id, '$checkin', '$checkout', '$status', NOW())";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con); // Return booking ID for guest insert
    }
    return false;
}

function updateBooking($id, $booking) {
    $con = getConnection();
    $id = intval($id);
    $fields = [];
    foreach (['user_id', 'room_id', 'checkin_date', 'checkout_date', 'status'] as $field) {
        if (isset($booking[$field])) {
            $val = mysqli_real_escape_string($con, $booking[$field]);
            $fields[] = "$field='$val'";
        }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE bookings SET " . implode(', ', $fields) . " WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteBooking($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM bookings WHERE id=$id";
    return mysqli_query($con, $sql);
}
function getBookingsByUser($user_id) {
    $con = getConnection();
    $user_id = intval($user_id);
    $sql = "SELECT * FROM bookings WHERE user_id=$user_id ORDER BY checkin_date DESC";
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) $bookings[] = $row;
    return $bookings;
}
?>