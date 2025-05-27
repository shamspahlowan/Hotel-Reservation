<?php
require_once(__DIR__ . '/../models/AmenityModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllAmenities') {
    echo json_encode(getAllAmenities());
    exit;
}
if ($action === 'addAmenity') {
    $amenity = [
        'name' => $_POST['name'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];
    echo json_encode(['success' => addAmenity($amenity)]);
    exit;
}
if ($action === 'deleteAmenity') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteAmenity($id)]);
    exit;
}
?>