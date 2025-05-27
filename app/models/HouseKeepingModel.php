<?php
require_once('db.php');

function getAllHousekeeping() {
    $con = getConnection();
    $sql = "SELECT * FROM housekeeping";
    $result = mysqli_query($con, $sql);
    $tasks = [];
    while ($row = mysqli_fetch_assoc($result)) $tasks[] = $row;
    return $tasks;
}

function addHousekeeping($task) {
    $con = getConnection();
    $room_id = intval($task['room_id']);
    $status = mysqli_real_escape_string($con, $task['status']);
    $reported_by = intval($task['reported_by']);
    $notes = mysqli_real_escape_string($con, $task['notes']);
    $sql = "INSERT INTO housekeeping (room_id, status, reported_by, reported_at, notes)
            VALUES ($room_id, '$status', $reported_by, NOW(), '$notes')";
    return mysqli_query($con, $sql);
}

function updateHousekeepingStatus($id, $status) {
    $con = getConnection();
    $id = intval($id);
    $status = mysqli_real_escape_string($con, $status);
    $sql = "UPDATE housekeeping SET status='$status' WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteHousekeeping($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM housekeeping WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>