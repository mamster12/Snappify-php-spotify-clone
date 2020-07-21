<?php 
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Asia/Hong_Kong");

    $database = getenv('DATABASE');
    $rootUser = getenv('ROOT_USER');
    $rootPass = getenv('ROOT_PASS');
    $dbName = getenv('DB_NAME');

    $con = mysqli_connect($database, $rootUser, $rootPass, $dbName);

    if(mysqli_connect_errno()){
        echo "Failed to connect: ". mysqli_connect_errno();
    }

?>