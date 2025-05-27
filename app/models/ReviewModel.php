<?php
require_once('db.php');

function getAllReviews() {
    $con = getConnection();
    $sql = "SELECT * FROM reviews";
    $result = mysqli_query($con, $sql);
    $reviews = [];
    while ($row = mysqli_fetch_assoc($result)) $reviews[] = $row;
    return $reviews;
}

function addReview($review) {
    $con = getConnection();
    $user_id = intval($review['user_id']);
    $room_id = intval($review['room_id']);
    $rating = intval($review['rating']);
    $comment = mysqli_real_escape_string($con, $review['comment']);
    $status = mysqli_real_escape_string($con, $review['status']);
    $sql = "INSERT INTO reviews (user_id, room_id, rating, comment, created_at, status)
            VALUES ($user_id, $room_id, $rating, '$comment', NOW(), '$status')";
    return mysqli_query($con, $sql);
}

function updateReviewStatus($id, $status) {
    $con = getConnection();
    $id = intval($id);
    $status = mysqli_real_escape_string($con, $status);
    $sql = "UPDATE reviews SET status='$status' WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteReview($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM reviews WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>