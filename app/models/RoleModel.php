<?php
require_once('db.php');

function getAllRoles() {
    $con = getConnection();
    $sql = "SELECT DISTINCT role FROM users";
    $result = mysqli_query($con, $sql);
    $roles = [];
    while ($row = mysqli_fetch_assoc($result)) $roles[] = $row['role'];
    return $roles;
}
?>