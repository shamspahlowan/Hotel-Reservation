<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json');
require_once('../models/UserModel.php');
require_once('../models/BookingModel.php');
require_once('../models/DashboardModel.php');
require_once('../models/HotelModel.php');

if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] !== "true") {
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'getDashboardStats':
            echo json_encode(getDashboardStats());
            break;
            
        case 'getRecentBookings':
            echo json_encode(getRecentBookings(10));
            break;
            
        case 'getAllBookings':
            echo json_encode(getAllBookings());
            break;
            
        case 'getAllUsers':
            echo json_encode(getAllUsers());
            break;
            
        case 'getTransactions':
            echo json_encode(getTransactions());
            break;
            
        case 'getAnalytics':
            echo json_encode(getAnalyticsData());
            break;

        case 'getAllHotels':
            echo json_encode(getAllHotels());
            break;
    
        case 'getHotelStats':
            echo json_encode(getHotelStats());
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['json'])) {
    $data = json_decode($_POST['json'], true);
    $action = $data['action'] ?? '';
    
    switch ($action) {
        case 'updateBookingStatus':
            $result = updateBookingStatus($data['booking_id'], $data['status']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'deleteUser':
            $result = deleteUser($data['user_id']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'updateUserRole':
            $result = updateUserRole($data['user_id'], $data['role']);
            echo json_encode(['success' => $result]);
            break;
            
        case 'addHotel':
            $hotel_id = addHotel($data);
            if ($hotel_id) {
                echo json_encode(['success' => true, 'hotel_id' => $hotel_id, 'message' => 'Hotel added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add hotel']);
            }
            break;
    
        case 'updateHotel':
            $result = updateHotel($data['hotel_id'], $data);
            echo json_encode(['success' => $result]);
            break;
    
        case 'deleteHotel':
            $result = deleteHotel($data['hotel_id']);
            echo json_encode(['success' => $result]);
            break;
            
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
    exit;
}

echo json_encode(['error' => 'Invalid request']);
?>