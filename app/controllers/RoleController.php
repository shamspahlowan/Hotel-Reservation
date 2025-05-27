<?php
require_once(__DIR__ . '/../models/RoleModel.php');

$action = $_REQUEST['action'] ?? '';

if ($action === 'getAllRoles') {
    echo json_encode(getAllRoles());
    exit;
}
?>