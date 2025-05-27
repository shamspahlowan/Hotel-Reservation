<?php
require_once(__DIR__ . '/../models/DashboardModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getDashboardStats') {
    echo json_encode(getDashboardStats());
    exit;
}
?>