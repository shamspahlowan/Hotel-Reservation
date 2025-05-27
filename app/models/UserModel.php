<?php
require_once('db.php');

// Login: returns user array if found, false otherwise
function login($user)
{
    $con = getConnection();
    $username = mysqli_real_escape_string($con, $user['username']);
    $password = mysqli_real_escape_string($con, $user['password']);
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        return false;
    }
}

// Get user by ID
function getUserById($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "SELECT * FROM users WHERE id=$id LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        return false;
    }
}

// Get all users
function getAllUsers()
{
    $con = getConnection();
    $sql = "SELECT * FROM users";
    $result = mysqli_query($con, $sql);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

// Add a new user
function addUser($user)
{
    $con = getConnection();
    $username = mysqli_real_escape_string($con, $user['username']);
    $email = mysqli_real_escape_string($con, $user['email']);
    $password = mysqli_real_escape_string($con, $user['password']);
    $role = isset($user['role']) ? mysqli_real_escape_string($con, $user['role']) : 'guest';
    $avatar = isset($user['avatar']) ? mysqli_real_escape_string($con, $user['avatar']) : null;

    $sql = "INSERT INTO users (username, email, password, role, avatar, created_at)
            VALUES ('$username', '$email', '$password', '$role', " . ($avatar ? "'$avatar'" : "NULL") . ", NOW())";
    return mysqli_query($con, $sql);
}

// Update user by ID
function updateUser($id, $user)
{
    $con = getConnection();
    $id = intval($id);
    $fields = [];
    if (isset($user['username'])) $fields[] = "username='" . mysqli_real_escape_string($con, $user['username']) . "'";
    if (isset($user['email'])) $fields[] = "email='" . mysqli_real_escape_string($con, $user['email']) . "'";
    if (isset($user['password'])) $fields[] = "password='" . mysqli_real_escape_string($con, $user['password']) . "'";
    if (isset($user['role'])) $fields[] = "role='" . mysqli_real_escape_string($con, $user['role']) . "'";
    if (isset($user['avatar'])) $fields[] = "avatar='" . mysqli_real_escape_string($con, $user['avatar']) . "'";
    if (empty($fields)) return false;
    $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id=$id";
    return mysqli_query($con, $sql);
}

// Delete user by ID
function deleteUser($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM users WHERE id=$id";
    return mysqli_query($con, $sql);
}
