<?php 
    ob_start();
    session_start();

    $timezone = date_default_timezone_set("Asia/Hong_Kong");

    $con = mysqli_connect("localhost", "root", "password54321", "snappify");
    // $con = mysqli_connect("us-cdbr-east-02.cleardb.com", "b93d1dc45b524a", "616a41d3", "heroku_4316f72bdb520f2");

    if(mysqli_connect_errno()){
        echo "Failed to connect: ". mysqli_connect_errno();
    }

?>