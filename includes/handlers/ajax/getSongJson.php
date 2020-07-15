<?php

    include("../../config.php"); // to enable database calls

    if(isset($_POST['songId'])) {
        $songId = $_POST['songId'];

        $query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'");

        $resultArray = mysqli_fetch_array($query);

        echo json_encode($resultArray);
    }

?>