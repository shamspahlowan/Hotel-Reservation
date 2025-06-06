<?php
require_once('db.php');

function login($email, $password) {
    $con = getConnection();
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return false;
}

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

function deleteUser($id)
{
    $con = getConnection();
    $id = intval($id);
    $sql = "DELETE FROM users WHERE id=$id";
    return mysqli_query($con, $sql);
}
function getUserByEmail($email) {
    $con = getConnection();
    $email = mysqli_real_escape_string($con, $email);
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $sql);
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    return false;
}

function updateUserPasswordByEmail($email, $password) {
    $con = getConnection();
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);
    $sql = "UPDATE users SET password='$password' WHERE email='$email' LIMIT 1";
    return mysqli_query($con, $sql);
}

function updateUserRole($user_id, $role) {
    $con = getConnection();
    $user_id = intval($user_id);
    $role = mysqli_real_escape_string($con, $role);
    $sql = "UPDATE users SET role='$role' WHERE id=$user_id";
    return mysqli_query($con, $sql);
}