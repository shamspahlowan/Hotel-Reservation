<?php
session_start();
require_once(__DIR__ . '/../models/BookingModel.php');
require_once(__DIR__ . '/../models/GuestModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllBookings') {
    echo json_encode(getAllBookings());
    exit;
}
if ($action === 'getBookingById') {
    $id = $_GET['id'] ?? 0;
    echo json_encode(getBookingById($id));
    exit;
}
if ($action === 'addBooking') {
    $booking = [
        'user_id' => $_POST['user_id'] ?? 0,
        'room_id' => $_POST['room_id'] ?? 0,
        'checkin_date' => $_POST['checkin_date'] ?? '',
        'checkout_date' => $_POST['checkout_date'] ?? '',
        'status' => $_POST['status'] ?? 'pending'
    ];
    $booking_id = addBooking($booking);
    if ($booking_id && isset($_POST['guests']) && is_array($_POST['guests'])) {
        foreach ($_POST['guests'] as $guest) {
            addGuest(['booking_id' => $booking_id, 'name' => $guest['name'], 'email' => $guest['email']]);
        }
    }
    echo json_encode(['success' => (bool)$booking_id, 'booking_id' => $booking_id]);
    exit;
}
if ($action === 'updateBooking') {
    $id = $_POST['id'] ?? 0;
    $booking = [];
    foreach (['user_id', 'room_id', 'checkin_date', 'checkout_date', 'status'] as $field) {
        if (isset($_POST[$field])) $booking[$field] = $_POST[$field];
    }
    echo json_encode(['success' => updateBooking($id, $booking)]);
    exit;
}
if ($action === 'deleteBooking') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deleteBooking($id)]);
    exit;
}
if ($action === 'getBookingsByUser') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode([]);
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $bookings = getBookingsByUser($user_id);
    echo json_encode($bookings);
    exit;
}
?>