<?php
require_once('db.php');

function getAllRooms() {
    $con = getConnection();
    $sql = "SELECT * FROM rooms";
    $result = mysqli_query($con, $sql);
    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) $rooms[] = $row;
    return $rooms;
}

function getRoomById($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM rooms WHERE id=$id LIMIT 1";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addRoom($room) {
    $con = getConnection();
    $room_number = mysqli_real_escape_string($con, $room['room_number']);
    $room_type_id = intval($room['room_type_id']);
    $price = floatval($room['price']);
    $status = mysqli_real_escape_string($con, $room['status']);
    $desc = mysqli_real_escape_string($con, $room['description']);
    $image = mysqli_real_escape_string($con, $room['image']);
    $sql = "INSERT INTO rooms (room_number, room_type_id, price, status, description, image)
            VALUES ('$room_number', $room_type_id, $price, '$status', '$desc', '$image')";
    return mysqli_query($con, $sql);
}

function updateRoom($id, $room) {
    $con = getConnection();
    $id = intval($id);
    $fields = [];
    foreach (['room_number', 'room_type_id', 'price', 'status', 'description', 'image'] as $field) {
        if (isset($room[$field])) {
            $val = mysqli_real_escape_string($con, $room[$field]);
            $fields[] = "$field='$val'";
        }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE rooms SET " . implode(', ', $fields) . " WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteRoom($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM rooms WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>