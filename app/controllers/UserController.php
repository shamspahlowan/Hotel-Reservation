<?php
require_once(__DIR__ . '/../models/UserModel.php');

// Example: Handle different actions based on a request parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_REQUEST['action'] ?? '';

    if ($action === 'login') {
        $user = [
            'username' => $_POST['username'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];
        $result = login($user);
        if ($result) {
            session_start();
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['role'] = $result['role'];
            echo json_encode(['success' => true, 'user' => $result]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
        }
        exit;
    }

    if ($action === 'getUserById') {
        $id = $_GET['id'] ?? 0;
        $user = getUserById($id);
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found']);
        }
        exit;
    }

    if ($action === 'getAllUsers') {
        $users = getAllUsers();
        echo json_encode(['success' => true, 'users' => $users]);
        exit;
    }

    if ($action === 'addUser') {
        $user = [
            'username' => $_POST['username'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'role' => $_POST['role'] ?? 'guest',
            'avatar' => $_POST['avatar'] ?? null
        ];
        $result = addUser($user);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add user']);
        }
        exit;
    }

    if ($action === 'updateUser') {
        $id = $_POST['id'] ?? 0;
        $user = [];
        foreach (['username', 'email', 'password', 'role', 'avatar'] as $field) {
            if (isset($_POST[$field])) $user[$field] = $_POST[$field];
        }
        $result = updateUser($id, $user);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update user']);
        }
        exit;
    }

    if ($action === 'deleteUser') {
        $id = $_POST['id'] ?? 0;
        $result = deleteUser($id);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete user']);
        }
        exit;
    }
}
?>