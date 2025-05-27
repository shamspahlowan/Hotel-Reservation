<?php
require_once(__DIR__ . '/../models/RoomTypeModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllRoomTypes') {
    echo json_encode(getAllRoomTypes());
    exit;
}
if ($action === 'getRoomTypeById') {
    $id = $_GET['id'] ?? 0;
    echo json_encode(getRoomTypeById($id));
    exit;
}
if ($action === 'addRoomType') {
    $type = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];
    echo json_encode(['success' => addRoomType($type)]);
    exit;
}
if ($action === 'updateRoomType') {
    $id = $_POST['id'] ?? 0;
    $type = [];
    foreach (['name', 'description'] as $field) {
        if (isset($_POST[$field])) $type[$field] = $_POST[$field];
    }
    echo json_encode(['success' => updateRoomType($id, $type)]);
    exit;
}
if ($action === 'deleteRoomType') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteRoomType($id)]);
    exit;
}
?>