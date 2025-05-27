<?php
require_once(__DIR__ . '/../models/PaymentModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllPayments') {
    echo json_encode(getAllPayments());
    exit;
}
if ($action === 'addPayment') {
    $payment = [
        'booking_id' => $_POST['booking_id'] ?? 0,
        'amount' => $_POST['amount'] ?? 0,
        'method' => $_POST['method'] ?? '',
        'status' => $_POST['status'] ?? 'pending'
    ];
    echo json_encode(['success' => addPayment($payment)]);
    exit;
}
if ($action === 'deletePayment') {
    $id = $_POST['id'] ?? 0;
    echo json_encode(['success' => deletePayment($id)]);
    exit;
}
?>