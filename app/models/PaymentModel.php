<?php
require_once('db.php');

function getAllPayments() {
    $con = getConnection();
    $sql = "SELECT * FROM payments";
    $result = mysqli_query($con, $sql);
    $payments = [];
    while ($row = mysqli_fetch_assoc($result)) $payments[] = $row;
    return $payments;
}

function addPayment($payment) {
    $con = getConnection();
    $booking_id = intval($payment['booking_id']);
    $amount = floatval($payment['amount']);
    $method = mysqli_real_escape_string($con, $payment['method']);
    $status = mysqli_real_escape_string($con, $payment['status']);
    $sql = "INSERT INTO payments (booking_id, amount, payment_date, method, status)
            VALUES ($booking_id, $amount, NOW(), '$method', '$status')";
    return mysqli_query($con, $sql);
}

function deletePayment($id) {
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM payments WHERE id=$id";
    return mysqli_query($con, $sql);
}
?>