<?php
require_once(__DIR__ . '/../models/GuestModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getGuestsByBooking') {
    $booking_id = $_GET['booking_id'] ?? 0;
    echo json_encode(getGuestsByBooking($booking_id));
    exit;
}
if ($action === 'addGuest') {
    $guest = [
        'booking_id' => $_POST['booking_id'] ?? 0,
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? ''
    ];
    echo json_encode(['success' => addGuest($guest)]);
    exit;
}
if ($action === 'deleteGuest') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteGuest($id)]);
    exit;
}
?>