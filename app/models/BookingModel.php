<?php
require_once('db.php');

function getBookingById($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM bookings WHERE id=$id LIMIT 1";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addBooking($booking) {
    $con = getConnection();
    $user_id = intval($booking['user_id']);
    $room_id = intval($booking['room_id']);
    $checkin = mysqli_real_escape_string($con, $booking['checkin_date']);
    $checkout = mysqli_real_escape_string($con, $booking['checkout_date']);
    $status = mysqli_real_escape_string($con, $booking['status']);
    $sql = "INSERT INTO bookings (user_id, room_id, checkin_date, checkout_date, status, created_at)
            VALUES ($user_id, $room_id, '$checkin', '$checkout', '$status', NOW())";
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    }
    return false;
}

function getRecentBookings($limit = 10) {
    $con = getConnection();
    $sql = "SELECT b.*, u.username as guest_name 
            FROM bookings b 
            LEFT JOIN users u ON b.user_id = u.id 
            ORDER BY b.created_at DESC 
            LIMIT $limit";
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    return $bookings;
}

function getAllBookings() {
    $con = getConnection();
    $sql = "SELECT b.*, u.username as guest_name 
            FROM bookings b 
            LEFT JOIN users u ON b.user_id = u.id 
            ORDER BY b.created_at DESC";
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    return $bookings;
}

function updateBooking($id, $booking) {
    $con = getConnection();
    $id = intval($id);
    $fields = [];
    foreach (['user_id', 'room_id', 'checkin_date', 'checkout_date', 'status'] as $field) {
        if (isset($booking[$field])) {
            $val = mysqli_real_escape_string($con, $booking[$field]);
            $fields[] = "$field='$val'";
        }
    }
    if (empty($fields)) return false;
    $sql = "UPDATE bookings SET " . implode(', ', $fields) . " WHERE id=$id";
    return mysqli_query($con, $sql);
}

function deleteBooking($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM bookings WHERE id=$id";
    return mysqli_query($con, $sql);
}

function getBookingsByUser($user_id) {
    $con = getConnection();
    $user_id = intval($user_id);
    $sql = "SELECT * FROM bookings WHERE user_id=$user_id ORDER BY checkin_date DESC";
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) $bookings[] = $row;
    return $bookings;
}

function updateBookingStatus($booking_id, $status) {
    $con = getConnection();
    $booking_id = intval($booking_id);
    $status = mysqli_real_escape_string($con, $status);
    $sql = "UPDATE bookings SET status='$status' WHERE id=$booking_id";
    return mysqli_query($con, $sql);
}

function getAvailableHotels() {
    $con = getConnection();
    $sql = "SELECT h.*, 
            (SELECT COUNT(*) FROM rooms r WHERE r.hotel_id = h.id AND r.status = 'available') as available_rooms
            FROM hotels h 
            WHERE h.status = 'active' 
            ORDER BY h.rating DESC";
    $result = mysqli_query($con, $sql);
    $hotels = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $hotels[] = $row;
    }
    return $hotels;
}

function getHotelAvailableRooms($hotel_id) {
    $con = getConnection();
    $hotel_id = intval($hotel_id);
    $sql = "SELECT r.*, 
            (SELECT AVG(rv.rating) FROM reviews rv WHERE rv.room_id = r.id) as avg_rating,
            (SELECT COUNT(*) FROM reviews rv WHERE rv.room_id = r.id) as review_count
            FROM rooms r 
            WHERE r.hotel_id = $hotel_id AND r.status = 'available'
            ORDER BY r.type, r.price ASC";
    $result = mysqli_query($con, $sql);
    $rooms = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rooms[] = $row;
    }
    return $rooms;
}

function checkRoomAvailability($room_id, $checkin, $checkout) {
    $con = getConnection();
    $room_id = intval($room_id);
    $checkin = mysqli_real_escape_string($con, $checkin);
    $checkout = mysqli_real_escape_string($con, $checkout);
    
    $sql = "SELECT COUNT(*) as conflicts FROM bookings 
            WHERE room_id = $room_id 
            AND status IN ('confirmed', 'checked_in', 'pending')
            AND ((checkin_date <= '$checkin' AND checkout_date > '$checkin') 
            OR (checkin_date < '$checkout' AND checkout_date >= '$checkout')
            OR (checkin_date >= '$checkin' AND checkout_date <= '$checkout'))";
    
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    
    return ['available' => $row['conflicts'] == 0];
}

function getRoomWithHotel($room_id) {
    $con = getConnection();
    $room_id = intval($room_id);
    $sql = "SELECT r.*, h.name as hotel_name, h.city, h.state, h.address, h.phone, h.amenities as hotel_amenities
            FROM rooms r 
            JOIN hotels h ON r.hotel_id = h.id 
            WHERE r.id = $room_id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function createBooking($data) {
    $con = getConnection();
    
    $availability = checkRoomAvailability($data['room_id'], $data['checkin_date'], $data['checkout_date']);
    if (!$availability['available']) {
        return ['success' => false, 'message' => 'Room is not available for selected dates'];
    }
    
    $room = getRoomWithHotel($data['room_id']);
    if (!$room) {
        return ['success' => false, 'message' => 'Room not found'];
    }
    
    $checkin = new DateTime($data['checkin_date']);
    $checkout = new DateTime($data['checkout_date']);
    $nights = $checkin->diff($checkout)->days;
    $total_amount = $room['price'] * $nights;
    
    $booking_reference = 'BK' . strtoupper(uniqid());
    
    $check_column = mysqli_query($con, "SHOW COLUMNS FROM bookings LIKE 'booking_reference'");
    $has_reference = mysqli_num_rows($check_column) > 0;
    
    $check_amount = mysqli_query($con, "SHOW COLUMNS FROM bookings LIKE 'total_amount'");
    $has_amount = mysqli_num_rows($check_amount) > 0;
    
    if ($has_reference && $has_amount) {
        $sql = "INSERT INTO bookings (
            user_id, room_id, booking_reference, checkin_date, checkout_date, 
            guests, total_amount, status, created_at
        ) VALUES (
            {$data['user_id']}, {$data['room_id']}, '$booking_reference', 
            '{$data['checkin_date']}', '{$data['checkout_date']}', 
            {$data['guests']}, $total_amount, 'pending', NOW()
        )";
    } else {
        $sql = "INSERT INTO bookings (
            user_id, room_id, checkin_date, checkout_date, status, created_at
        ) VALUES (
            {$data['user_id']}, {$data['room_id']}, 
            '{$data['checkin_date']}', '{$data['checkout_date']}', 
            'pending', NOW()
        )";
    }
    
    if (mysqli_query($con, $sql)) {
        $booking_id = mysqli_insert_id($con);
        
        $check_payments = mysqli_query($con, "SHOW TABLES LIKE 'payments'");
        if (mysqli_num_rows($check_payments) > 0) {
            createPaymentRecord($booking_id, $total_amount, 'pending');
        }
        
        return [
            'success' => true, 
            'booking_id' => $booking_id, 
            'booking_reference' => $booking_reference,
            'total_amount' => $total_amount,
            'nights' => $nights,
            'message' => 'Booking created successfully'
        ];
    } else {
        return ['success' => false, 'message' => 'Failed to create booking: ' . mysqli_error($con)];
    }
}

function createGroupBooking($data) {
    $con = getConnection();
    
    mysqli_begin_transaction($con);
    
    try {
        $total_amount = 0;
        $booking_ids = [];
        $checkin = new DateTime($data['checkin_date']);
        $checkout = new DateTime($data['checkout_date']);
        $nights = $checkin->diff($checkout)->days;
        
        $group_reference = 'GRP' . strtoupper(uniqid());
        
        foreach ($data['rooms'] as $room_data) {
            for ($i = 0; $i < $room_data['quantity']; $i++) {
                $room_sql = "SELECT id, price FROM rooms 
                           WHERE hotel_id = {$data['hotel_id']} 
                           AND type = '{$room_data['type']}' 
                           AND status = 'available'
                           AND id NOT IN (
                               SELECT room_id FROM bookings 
                               WHERE status IN ('confirmed', 'checked_in', 'pending')
                               AND ((checkin_date <= '{$data['checkin_date']}' AND checkout_date > '{$data['checkin_date']}') 
                               OR (checkin_date < '{$data['checkout_date']}' AND checkout_date >= '{$data['checkout_date']}')
                               OR (checkin_date >= '{$data['checkin_date']}' AND checkout_date <= '{$data['checkout_date']}'))
                           )
                           LIMIT 1";
                
                $room_result = mysqli_query($con, $room_sql);
                $room = mysqli_fetch_assoc($room_result);
                
                if (!$room) {
                    throw new Exception("Not enough available {$room_data['type']} rooms");
                }
                
                $room_total = $room['price'] * $nights;
                $total_amount += $room_total;
                
                $booking_reference = $group_reference . '-' . ($i + 1);
                
                $check_columns = mysqli_query($con, "SHOW COLUMNS FROM bookings LIKE 'booking_reference'");
                $has_extended = mysqli_num_rows($check_columns) > 0;
                
                if ($has_extended) {
                    $booking_sql = "INSERT INTO bookings (
                        user_id, room_id, booking_reference, checkin_date, checkout_date, 
                        guests, total_amount, status, booking_type, 
                        group_reference, payment_terms, created_at
                    ) VALUES (
                        {$data['user_id']}, {$room['id']}, '$booking_reference', 
                        '{$data['checkin_date']}', '{$data['checkout_date']}', 
                        1, $room_total, 'pending', 
                        'group', '$group_reference', '{$data['payment_terms']}', NOW()
                    )";
                } else {
                    $booking_sql = "INSERT INTO bookings (
                        user_id, room_id, checkin_date, checkout_date, status, created_at
                    ) VALUES (
                        {$data['user_id']}, {$room['id']}, 
                        '{$data['checkin_date']}', '{$data['checkout_date']}', 
                        'pending', NOW()
                    )";
                }
                
                if (!mysqli_query($con, $booking_sql)) {
                    throw new Exception("Failed to create booking");
                }
                
                $booking_ids[] = mysqli_insert_id($con);
            }
        }
        
        if ($data['event_space'] && $data['event_space'] !== 'none') {
            $event_costs = [
                'conference' => 500,
                'banquet' => 1000
            ];
            $total_amount += $event_costs[$data['event_space']] ?? 0;
        }
        
        $check_payments = mysqli_query($con, "SHOW TABLES LIKE 'payments'");
        if (mysqli_num_rows($check_payments) > 0) {
            createPaymentRecord($booking_ids[0], $total_amount, 'pending', $group_reference);
        }
        
        $check_guests = mysqli_query($con, "SHOW TABLES LIKE 'booking_guests'");
        if (mysqli_num_rows($check_guests) > 0 && isset($data['guests'])) {
            foreach ($data['guests'] as $guest) {
                $guest_sql = "INSERT INTO booking_guests (booking_id, name, email) 
                             VALUES ({$booking_ids[0]}, 
                             '" . mysqli_real_escape_string($con, $guest['name']) . "', 
                             '" . mysqli_real_escape_string($con, $guest['email']) . "')";
                mysqli_query($con, $guest_sql);
            }
        }
        
        mysqli_commit($con);
        
        return [
            'success' => true,
            'group_reference' => $group_reference,
            'booking_ids' => $booking_ids,
            'total_amount' => $total_amount,
            'nights' => $nights,
            'message' => 'Group booking created successfully'
        ];
        
    } catch (Exception $e) {
        mysqli_rollback($con);
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function createPaymentRecord($booking_id, $amount, $status, $group_reference = null) {
    $con = getConnection();
    $payment_reference = 'PAY' . strtoupper(uniqid());
    
    $check_columns = mysqli_query($con, "SHOW COLUMNS FROM payments LIKE 'payment_reference'");
    $has_extended = mysqli_num_rows($check_columns) > 0;
    
    if ($has_extended) {
        $sql = "INSERT INTO payments (
            booking_id, amount, status, payment_reference, payment_method, 
            transaction_id, created_at
        ) VALUES (
            $booking_id, $amount, '$status', '$payment_reference', 
            'pending', NULL, NOW()
        )";
    } else {
        $sql = "INSERT INTO payments (booking_id, amount, status, created_at) 
                VALUES ($booking_id, $amount, '$status', NOW())";
    }
    
    return mysqli_query($con, $sql);
}

function getUserBookingsDetailed($user_id) {
    $con = getConnection();
    $user_id = intval($user_id);
    
    $sql = "SELECT b.*, r.room_number, r.type as room_type, h.name as hotel_name, 
            h.city, h.address, p.status as payment_status, p.amount as payment_amount
            FROM bookings b
            LEFT JOIN rooms r ON b.room_id = r.id
            LEFT JOIN hotels h ON r.hotel_id = h.id
            LEFT JOIN payments p ON b.id = p.booking_id
            WHERE b.user_id = $user_id
            ORDER BY b.created_at DESC";
    
    $result = mysqli_query($con, $sql);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    return $bookings;
}

function cancelBooking($booking_id, $user_id) {
    $con = getConnection();
    $booking_id = intval($booking_id);
    $user_id = intval($user_id);
    
    $check_sql = "SELECT status, checkin_date FROM bookings 
                  WHERE id = $booking_id AND user_id = $user_id";
    $result = mysqli_query($con, $check_sql);
    $booking = mysqli_fetch_assoc($result);
    
    if (!$booking) {
        return ['success' => false, 'message' => 'Booking not found'];
    }
    
    if ($booking['status'] === 'cancelled') {
        return ['success' => false, 'message' => 'Booking already cancelled'];
    }
    
    $checkin = new DateTime($booking['checkin_date']);
    $now = new DateTime();
    $hours_until_checkin = ($checkin->getTimestamp() - $now->getTimestamp()) / 3600;
    
    if ($hours_until_checkin < 24) {
        return ['success' => false, 'message' => 'Cannot cancel booking less than 24 hours before check-in'];
    }
    
    $update_sql = "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id";
    
    if (mysqli_query($con, $update_sql)) {
        $check_payments = mysqli_query($con, "SHOW TABLES LIKE 'payments'");
        if (mysqli_num_rows($check_payments) > 0) {
            mysqli_query($con, "UPDATE payments SET status = 'cancelled' WHERE booking_id = $booking_id");
        }
        return ['success' => true, 'message' => 'Booking cancelled successfully'];
    } else {
        return ['success' => false, 'message' => 'Failed to cancel booking'];
    }
}
?>