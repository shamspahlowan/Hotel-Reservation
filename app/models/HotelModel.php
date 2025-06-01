<?php
require_once('db.php');

function getAllHotels() {
    $con = getConnection();
    $sql = "SELECT h.*, 
            (SELECT COUNT(*) FROM rooms r WHERE r.hotel_id = h.id) as actual_rooms,
            (SELECT AVG(rv.rating) FROM reviews rv 
             JOIN rooms r ON rv.room_id = r.id 
             WHERE r.hotel_id = h.id) as avg_rating
            FROM hotels h 
            ORDER BY h.created_at DESC";
    $result = mysqli_query($con, $sql);
    $hotels = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $hotels[] = $row;
    }
    return $hotels;
}

function getHotelById($hotel_id) {
    $con = getConnection();
    $hotel_id = intval($hotel_id);
    $sql = "SELECT h.*, 
            (SELECT COUNT(*) FROM rooms r WHERE r.hotel_id = h.id) as actual_rooms,
            (SELECT AVG(rv.rating) FROM reviews rv 
             JOIN rooms r ON rv.room_id = r.id 
             WHERE r.hotel_id = h.id) as avg_rating
            FROM hotels h 
            WHERE h.id = $hotel_id";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

function addHotel($data) {
    $con = getConnection();
    $name = mysqli_real_escape_string($con, $data['name']);
    $description = mysqli_real_escape_string($con, $data['description'] ?? '');
    $address = mysqli_real_escape_string($con, $data['address']);
    $city = mysqli_real_escape_string($con, $data['city']);
    $state = mysqli_real_escape_string($con, $data['state']);
    $country = mysqli_real_escape_string($con, $data['country']);
    $postal_code = mysqli_real_escape_string($con, $data['postal_code'] ?? '');
    $phone = mysqli_real_escape_string($con, $data['phone'] ?? '');
    $email = mysqli_real_escape_string($con, $data['email'] ?? '');
    $website = mysqli_real_escape_string($con, $data['website'] ?? '');
    $total_rooms = intval($data['total_rooms'] ?? 0);
    $amenities = mysqli_real_escape_string($con, $data['amenities'] ?? '');
    $image = mysqli_real_escape_string($con, $data['image'] ?? '');
    
    $sql = "INSERT INTO hotels (name, description, address, city, state, country, postal_code, phone, email, website, total_rooms, amenities, image) 
            VALUES ('$name', '$description', '$address', '$city', '$state', '$country', '$postal_code', '$phone', '$email', '$website', $total_rooms, '$amenities', '$image')";
    
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    }
    return false;
}

function updateHotel($hotel_id, $data) {
    $con = getConnection();
    $hotel_id = intval($hotel_id);
    $fields = [];
    
    if (isset($data['name'])) $fields[] = "name='" . mysqli_real_escape_string($con, $data['name']) . "'";
    if (isset($data['description'])) $fields[] = "description='" . mysqli_real_escape_string($con, $data['description']) . "'";
    if (isset($data['address'])) $fields[] = "address='" . mysqli_real_escape_string($con, $data['address']) . "'";
    if (isset($data['city'])) $fields[] = "city='" . mysqli_real_escape_string($con, $data['city']) . "'";
    if (isset($data['state'])) $fields[] = "state='" . mysqli_real_escape_string($con, $data['state']) . "'";
    if (isset($data['country'])) $fields[] = "country='" . mysqli_real_escape_string($con, $data['country']) . "'";
    if (isset($data['postal_code'])) $fields[] = "postal_code='" . mysqli_real_escape_string($con, $data['postal_code']) . "'";
    if (isset($data['phone'])) $fields[] = "phone='" . mysqli_real_escape_string($con, $data['phone']) . "'";
    if (isset($data['email'])) $fields[] = "email='" . mysqli_real_escape_string($con, $data['email']) . "'";
    if (isset($data['website'])) $fields[] = "website='" . mysqli_real_escape_string($con, $data['website']) . "'";
    if (isset($data['total_rooms'])) $fields[] = "total_rooms=" . intval($data['total_rooms']);
    if (isset($data['amenities'])) $fields[] = "amenities='" . mysqli_real_escape_string($con, $data['amenities']) . "'";
    if (isset($data['image'])) $fields[] = "image='" . mysqli_real_escape_string($con, $data['image']) . "'";
    if (isset($data['status'])) $fields[] = "status='" . mysqli_real_escape_string($con, $data['status']) . "'";
    if (isset($data['rating'])) $fields[] = "rating=" . floatval($data['rating']);
    
    if (empty($fields)) return false;
    
    $sql = "UPDATE hotels SET " . implode(', ', $fields) . " WHERE id=$hotel_id";
    return mysqli_query($con, $sql);
}

function deleteHotel($hotel_id) {
    $con = getConnection();
    $hotel_id = intval($hotel_id);
    $sql = "DELETE FROM hotels WHERE id=$hotel_id";
    return mysqli_query($con, $sql);
}

function getHotelStats() {
    $con = getConnection();
    $stats = [];
    
    $result = mysqli_query($con, "SELECT COUNT(*) as total FROM hotels");
    $stats['total'] = mysqli_fetch_assoc($result)['total'];
    
    $result = mysqli_query($con, "SELECT COUNT(*) as active FROM hotels WHERE status='active'");
    $stats['active'] = mysqli_fetch_assoc($result)['active'];
    
    $result = mysqli_query($con, "SELECT SUM(total_rooms) as total_rooms FROM hotels");
    $stats['total_rooms'] = mysqli_fetch_assoc($result)['total_rooms'] ?? 0;
    
    $result = mysqli_query($con, "SELECT AVG(rv.rating) as avg_rating 
                                  FROM reviews rv 
                                  JOIN rooms r ON rv.room_id = r.id 
                                  JOIN hotels h ON r.hotel_id = h.id");
    $stats['avg_rating'] = round(mysqli_fetch_assoc($result)['avg_rating'] ?? 0, 1);
    
    return $stats;
}
?>