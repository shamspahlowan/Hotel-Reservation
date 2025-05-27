<?php
require_once('db.php');

function getUserPoints($user_id) {
    $con = getConnection();
    $user_id = intval($user_id);
    $sql = "SELECT points FROM loyalty_points WHERE user_id=$user_id";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) return $row['points'];
    return 0;
}

function addPoints($user_id, $points) {
    $con = getConnection();
    $user_id = intval($user_id);
    $points = intval($points);
    $sql = "INSERT INTO loyalty_points (user_id, points, updated_at) VALUES ($user_id, $points, NOW())
            ON DUPLICATE KEY UPDATE points=points+$points, updated_at=NOW()";
    return mysqli_query($con, $sql);
}
?>