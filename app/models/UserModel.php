<?php
    require_once('db.php');

    function login($user){
        $con = getConnection();
        $sql = "select * from users where username='{$user['username']}' and password='{$user['password']}'";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) == 1){
            return true;
        }else{
            return false;
        }
    }

    function addUser($user){
        $con = getConnection();
        $sql = "insert into userinfo values('{$user['username']}', '{$user['email']}', '{$user['password']}')";
        if(mysqli_query($con, $sql)){
            mysqli_close($con);
            return true;
        }else{
            return false;
        }
    }


    function getUserById($id){

    }

    function getAllUsers(){

    }

    function deleteUser($id){

    }

    function updateUser($user){

    }
?>