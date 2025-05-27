<?php
require_once('db.php');

function getAllRoomTypes() {
    $con = getConnection();
    $sql = "SELECT * FROM room_types";
    $result = mysqli_query($con, $sql);
    $types = [];
    while ($row = mysqli_fetch_assoc($result)) $types[] = $row;
    return $types;
}

function getRoomTypeById($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM room_types WHERE id=$id LIMIT 1";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addRoomType($type) {
    $con = getConnection();
    $name = mysqli_real_escape_string($con, $type['name']);
    $desc = mysqli_real_escape_string($con, $type['description']);
    $sql = "INSERT INTO room_types (name, description) VALUES ('$name', '$desc')";
    return mysqli_query($con, $sql);
}

function updateRoomType($id, $type) {
    $con = getConnection();
    $id = intval($id);
    $fields = [];
    if (isset($type['name'])) $fields[] = "name='" . mysqli_real_escape_string($con, $type['name']) . "'";
    if (isset($type['description'])) $fields[] = "description='" . mysqli_real_escape_string($con, $type['description']) . "'";
    if (empty($fields)) return false;
    $sql = "UPDATE room_types SET " . implode(', ', $fields) . " WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteRoomType($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM room_types WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>