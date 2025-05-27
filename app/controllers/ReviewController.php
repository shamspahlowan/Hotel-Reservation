<?php
require_once(__DIR__ . '/../models/ReviewModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllReviews') {
    echo json_encode(getAllReviews());
    exit;
}
if ($action === 'addReview') {
    $review = [
        'user_id' => $_POST['user_id'] ?? 0,
        'room_id' => $_POST['room_id'] ?? 0,
        'rating' => $_POST['rating'] ?? 0,
        'comment' => $_POST['comment'] ?? '',
        'status' => $_POST['status'] ?? 'pending'
    ];
    echo json_encode(['success' => addReview($review)]);
    exit;
}
if ($action === 'updateReviewStatus') {
    $id = $_POST['id'] ?? 0;
    $status = $_POST['status'] ?? 'pending';
    echo json_encode(['success' => updateReviewStatus($id, $status)]);
    exit;
}
if ($action === 'deleteReview') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteReview($id)]);
    exit;
}
?>