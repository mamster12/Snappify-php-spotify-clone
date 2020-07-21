<?php 
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Asia/Hong_Kong");

    $con = mysqli_connect(DATABASE, ROOT_USER, ROOT_PASS, DB_NAME);

    if(mysqli_connect_errno()){
        echo "Failed to connect: ". mysqli_connect_errno();
    }

?>