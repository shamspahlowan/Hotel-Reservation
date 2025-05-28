<?php
require_once(__DIR__ . '/../models/RoomTypeModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllRoomTypes') {
    $roomTypes = getAllRoomTypes();
    $con = getConnection();
    $ids = implode(',', array_map('intval', array_column($roomTypes, 'id')));
    $sql = "SELECT rta.room_type_id, a.name AS amenity FROM room_type_amenity rta 
            JOIN amenities a ON rta.amenity_id = a.id 
            WHERE rta.room_type_id IN ($ids)";
    $result = mysqli_query($con, $sql);
    $amenitiesMap = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $amenitiesMap[$row['room_type_id']][] = $row['amenity'];
    }
    foreach ($roomTypes as &$type) {
        $type['amenities'] = $amenitiesMap[$type['id']] ?? [];
    }
   ACR echo json_encode($roomTypes);
    exit;
}

if ($action === 'getRoomTypeById') {
    $id = $_GET['id'] ?? 0;
    $roomType = getRoomTypeById($id);
    if ($roomType) {
        $con = getConnection();
        $sql = "SELECT a.name AS amenity FROM room_type_amenity rta 
                JOIN amenities a ON rta.amenity_id = a.id 
                WHERE rta.room_type_id = $id";
        $result = mysqli_query($con, $sql);
        $amenities = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $amenities[] = $row['amenity'];
        }
        $roomType['amenities'] = $amenities;
    }
    echo json_encode($roomType ?: ['error' => 'Room type not found']);
    exit;
}

if ($action === 'addRoomType') {
    $type = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? null
    ];
    $success = addRoomType($type);
    if ($success && isset($_POST['amenities'])) {
        $con = getConnection();
        $id = mysqli_insert_id($con);
        $amenities = array_map('intval', (array)$_POST['amenities']);
        $values = implode(',', array_map(fn($a) => "($id, $a)", $amenities));
        $sql = "INSERT INTO room_type_amenity (room_type_id, amenity_id) VALUES $values";
        mysqli_query($con, $sql);
    }
    echo json_encode(['success' => $success]);
    exit;
}

if ($action === 'updateRoomType') {
    $id = $_POST['id'] ?? 0;
    $type = [];
    foreach (['name', 'description'] as $field) {
        if (isset($_POST[$field])) $type[$field] = $_POST[$field];
    }
    $success = updateRoomType($id, $type);
    if ($success && isset($_POST['amenities'])) {
        $con = getConnection();
        mysqli_query($con, "DELETE FROM room_type_amenity WHERE room_type_id = $id");
        $amenities = array_map('intval', (array)$_POST['amenities']);
        $values = implode(',', array_map(fn($a) => "($id, $a)", $amenities));
        $sql = "INSERT INTO room_type_amenity (room_type_id, amenity_id) VALUES $values";
        mysqli_query($con, $sql);
    }
    echo json_encode(['success' => $success]);
    exit;
}

if ($action === 'deleteRoomType') {
    $id = $_POST['id'] ?? 0;
    $con = getConnection();
    mysqli_query($con, "DELETE FROM room_type_amenity WHERE room_type_id = $id");
    $success = deleteRoomType($id);
    echo json_encode(['success' => $success]);
    exit;
}
?>