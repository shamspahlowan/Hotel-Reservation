<?php
session_start();
header('Content-Type: application/json');
require_once('../models/BookingModel.php');
require_once('../models/UserModel.php');
require_once('../models/HotelModel.php');
require_once('../models/GuestModel.php');

if (!isset($_SESSION['status'])) {
    echo json_encode(['error' => 'Please login to make a booking']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'getHotels':
            echo json_encode(getAvailableHotels());
            break;
            
        case 'getHotelRooms':
            $hotel_id = intval($_GET['hotel_id']);
            echo json_encode(getHotelAvailableRooms($hotel_id));
            break;
            
        case 'checkAvailability':
            $room_id = intval($_GET['room_id']);
            $checkin = $_GET['checkin'];
            $checkout = $_GET['checkout'];
            echo json_encode(checkRoomAvailability($room_id, $checkin, $checkout));
            break;
            
        case 'getRoomDetails':
            $room_id = intval($_GET['room_id']);
            echo json_encode(getRoomWithHotel($room_id));
            break;
            
        case 'getUserBookings':
            $user_id = $_SESSION['user_id'];
            echo json_encode(getUserBookingsDetailed($user_id));
            break;
            
        case 'getAllBookings':
            echo json_encode(getAllBookings());
            break;
            
        case 'getBookingById':
            $id = $_GET['id'] ?? 0;
            echo json_encode(getBookingById($id));
            break;
            
        case 'getBookingsByUser':
            if (!isset($_SESSION['user_id'])) {
                echo json_encode([]);
                exit;
            }
            $user_id = $_SESSION['user_id'];
            $bookings = getBookingsByUser($user_id);
            echo json_encode($bookings);
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!$data && isset($_POST['json'])) {
        $data = json_decode($_POST['json'], true);
    }
    
    if (!$data) {
        $data = $_POST;
    }
    
    $action = $data['action'] ?? '';
    
    switch ($action) {
        case 'createSingleBooking':
            $booking_data = [
                'user_id' => $_SESSION['user_id'],
                'room_id' => $data['room_id'],
                'checkin_date' => $data['checkin_date'],
                'checkout_date' => $data['checkout_date'],
                'guests' => $data['guests'] ?? 1,
                'special_requests' => $data['special_requests'] ?? '',
                'booking_type' => 'single'
            ];
            $result = createBooking($booking_data);
            echo json_encode($result);
            break;
            
        case 'createGroupBooking':
            $booking_data = [
                'user_id' => $_SESSION['user_id'],
                'hotel_id' => $data['hotel_id'],
                'checkin_date' => $data['checkin_date'],
                'checkout_date' => $data['checkout_date'],
                'rooms' => $data['rooms'],
                'guests' => $data['guests'],
                'payment_terms' => $data['payment_terms'],
                'event_space' => $data['event_space'] ?? null,
                'special_requests' => $data['special_requests'] ?? '',
                'booking_type' => 'group'
            ];
            $result = createGroupBooking($booking_data);
            echo json_encode($result);
            break;
            
        case 'cancelBooking':
            $booking_id = intval($data['booking_id'] ?? $data['id']);
            $user_id = $_SESSION['user_id'];
            $result = cancelBooking($booking_id, $user_id);
            echo json_encode($result);
            break;
            
        case 'addBooking':
            $booking = [
                'user_id' => $data['user_id'] ?? $_SESSION['user_id'],
                'room_id' => $data['room_id'] ?? 0,
                'checkin_date' => $data['checkin_date'] ?? '',
                'checkout_date' => $data['checkout_date'] ?? '',
                'status' => $data['status'] ?? 'pending'
            ];
            $booking_id = addBooking($booking);
            if ($booking_id && isset($data['guests']) && is_array($data['guests'])) {
                foreach ($data['guests'] as $guest) {
                    addGuest(['booking_id' => $booking_id, 'name' => $guest['name'], 'email' => $guest['email']]);
                }
            }
            echo json_encode(['success' => (bool)$booking_id, 'booking_id' => $booking_id]);
            break;
            
        case 'updateBooking':
            $id = $data['id'] ?? 0;
            $booking = [];
            foreach (['user_id', 'room_id', 'checkin_date', 'checkout_date', 'status'] as $field) {
                if (isset($data[$field])) $booking[$field] = $data[$field];
            }
            echo json_encode(['success' => updateBooking($id, $booking)]);
            break;
            
        case 'deleteBooking':
            $id = $data['id'] ?? 0;
            echo json_encode(['success' => deleteBooking($id)]);
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

echo json_encode(['error' => 'Invalid request']);
?>