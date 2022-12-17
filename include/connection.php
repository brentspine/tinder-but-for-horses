<?php

    $host = '127.0.0.1';
    $db   = 'school_tinder';
    $user = 'root';
    $pass = 'root';


    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $con = new mysqli($host, $user, $pass, $db);
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    if($con->connect_error) {
        die("Connection failed test: " .$con->connect_error);
        return;
    }

?>