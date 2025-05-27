<?php
require_once(__DIR__ . '/../models/LoyaltyModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getUserPoints') {
    $user_id = $_GET['user_id'] ?? 0;
    echo json_encode(['points' => getUserPoints($user_id)]);
    exit;
}
if ($action === 'addPoints') {
    $user_id = $_POST['user_id'] ?? 0;
    $points = $_POST['points'] ?? 0;
    echo json_encode(['success' => addPoints($user_id, $points)]);
    exit;
}
?>