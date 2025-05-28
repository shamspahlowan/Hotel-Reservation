<?php

session_start();
header('Content-Type: application/json');
require_once('../models/SearchModel.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'searchRooms':
            $filters = [
                'keyword' => $_GET['keyword'] ?? '',
                'room_type' => $_GET['room_type'] ?? '',
                'min_price' => $_GET['min_price'] ?? 0,
                'max_price' => $_GET['max_price'] ?? 9999,
                'amenities' => $_GET['amenities'] ?? [],
                'checkin' => $_GET['checkin'] ?? '',
                'checkout' => $_GET['checkout'] ?? '',
                'guests' => $_GET['guests'] ?? 1
            ];
            echo json_encode(searchAvailableRooms($filters));
            break;
            
        case 'getRoomDetails':
            $room_id = intval($_GET['room_id']);
            echo json_encode(getRoomDetails($room_id));
            break;
            
        case 'getHotelRooms':
            $hotel_id = intval($_GET['hotel_id']);
            echo json_encode(getHotelRooms($hotel_id));
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

echo json_encode(['error' => 'Invalid request']);
?>