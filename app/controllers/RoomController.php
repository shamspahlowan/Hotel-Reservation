<?php
require_once(__DIR__ . '/../models/RoomModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllRooms') {
    echo json_encode(getAllRooms());
    exit;
}
if ($action === 'getRoomById') {
    $id = $_GET['id'] ?? 0;
    echo json_encode(getRoomById($id));
    exit;
}
if ($action === 'addRoom') {
    $room = [
        'room_number' => $_POST['room_number'] ?? '',
        'room_type_id' => $_POST['room_type_id'] ?? 0,
        'price' => $_POST['price'] ?? 0,
        'status' => $_POST['status'] ?? 'available',
        'description' => $_POST['description'] ?? '',
        'image' => $_POST['image'] ?? ''
    ];
    echo json_encode(['success' => addRoom($room)]);
    exit;
}
if ($action === 'updateRoom') {
    $id = $_POST['id'] ?? 0;
    $room = [];
    foreach (['room_number', 'room_type_id', 'price', 'status', 'description', 'image'] as $field) {
        if (isset($_POST[$field])) $room[$field] = $_POST[$field];
    }
    echo json_encode(['success' => updateRoom($id, $room)]);
    exit;
}
if ($action === 'deleteRoom') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteRoom($id)]);
    exit;
}
?>