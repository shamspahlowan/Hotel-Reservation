<?php

    $host = "127.0.0.1";
    $dbname = "practicedb";
    $dbuser = "root";
    $dbpass = "";

    function getConnection(){
        //global $host;
        global $dbname;
        global $dbuser;
        global $dbpass;

        $con = mysqli_connect($GLOBALS['host'], $dbuser, $dbpass, $dbname);
        return $con;
    }

?>