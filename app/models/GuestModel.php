<?php
require_once('db.php');

function getGuestsByBooking($booking_id) {
    $con = getConnection();
    $booking_id = intval($booking_id);
    $sql = "SELECT * FROM guests WHERE booking_id=$booking_id";
    $result = mysqli_query($con, $sql);
    $guests = [];
    while ($row = mysqli_fetch_assoc($result)) $guests[] = $row;
    return $guests;
}

function addGuest($guest) {
    $con = getConnection();
    $booking_id = intval($guest['booking_id']);
    $name = mysqli_real_escape_string($con, $guest['name']);
    $email = mysqli_real_escape_string($con, $guest['email']);
    $sql = "INSERT INTO guests (booking_id, name, email) VALUES ($booking_id, '$name', '$email')";
    return mysqli_query($con, $sql);
}

function deleteGuest($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM guests WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>