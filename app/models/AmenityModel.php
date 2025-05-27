<?php
require_once('db.php');

function getAllAmenities() {
    $con = getConnection();
    $sql = "SELECT * FROM amenities";
    $result = mysqli_query($con, $sql);
    $amenities = [];
    while ($row = mysqli_fetch_assoc($result)) $amenities[] = $row;
    return $amenities;
}

function addAmenity($amenity) {
    $con = getConnection();
    $name = mysqli_real_escape_string($con, $amenity['name']);
    $desc = mysqli_real_escape_string($con, $amenity['description']);
    $sql = "INSERT INTO amenities (name, description) VALUES ('$name', '$desc')";
    return mysqli_query($con, $sql);
}

function deleteAmenity($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM amenities WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>