<?php
require_once(__DIR__ . '/../models/RoomModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllRooms') {
    $roomTypeId = $_GET['room_type_id'] ?? '';
    $rooms = getAllRooms();
    if (!empty($rooms)) {
        $con = getConnection();
        $ids = implode(',', array_map('intval', array_column($rooms, 'room_type_id')));
        $sql = "SELECT id, name FROM room_types WHERE id IN ($ids)";
        $result = mysqli_query($con, $sql);
        $typeMap = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $typeMap[$row['id']] = $row['name'];
        }
        foreach ($rooms as &$room) {
            $room['room_type_name'] = $typeMap[$room['room_type_id']] ?? 'Unknown';
            $sql = "SELECT a.name AS amenity FROM room_type_amenity rta 
                    JOIN amenities a ON rta.amenity_id = a.id 
                    WHERE rta.room_type_id = " . intval($room['room_type_id']);
            $result = mysqli_query($con, $sql);
            $amenities = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $amenities[] = $row['amenity'];
            }
            $room['amenities'] = $amenities;
        }
        if ($roomTypeId) {
            $rooms = array_filter($rooms, fn($room) => $room['room_type_id'] == $roomTypeId);
        }
    }
    echo json_encode(array_values($rooms));
    exit;
}

if ($action === 'getRoomById') {
    $id = $_GET['id'] ?? 0;
    $room = getRoomById($id);
    if ($room) {
        $con = getConnection();
        $sql = "SELECT name FROM room_types WHERE id = " . intval($room['room_type_id']);
        $result = mysqli_query($con, $sql);
        $type = mysqli_fetch_assoc($result);
        $room['room_type_name'] = $type['name'] ?? 'Unknown';
        $sql = "SELECT a.name AS amenity FROM room_type_amenity rta 
                JOIN amenities a ON rta.amenity_id = a.id 
                WHERE rta.room_type_id = " . intval($room['room_type_id']);
        $result = mysqli_query($con, $sql);
        $amenities = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $amenities[] = $row['amenity'];
        }
        $room['amenities'] = $amenities;
    }
    echo json_encode($room ?: ['error' => 'Room not found']);
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