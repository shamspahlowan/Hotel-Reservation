<?php
require_once(__DIR__ . '/../models/HousekeepingModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllHousekeeping') {
    echo json_encode(getAllHousekeeping());
    exit;
}
if ($action === 'addHousekeeping') {
    $task = [
        'room_id' => $_POST['room_id'] ?? 0,
        'status' => $_POST['status'] ?? 'clean',
        'reported_by' => $_POST['reported_by'] ?? 0,
        'notes' => $_POST['notes'] ?? ''
    ];
    echo json_encode(['success' => addHousekeeping($task)]);
    exit;
}
if ($action === 'updateHousekeepingStatus') {
    $id = $_POST['id'] ?? 0;
    $status = $_POST['status'] ?? 'clean';
    echo json_encode(['success' => updateHousekeepingStatus($id, $status)]);
    exit;
}
if ($action === 'deleteHousekeeping') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteHousekeeping($id)]);
    exit;
}
?>