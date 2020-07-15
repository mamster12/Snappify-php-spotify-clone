<?php

    include("../../config.php"); // to enable database calls

    if(isset($_POST['artistId'])) {
        $artistId = $_POST['artistId'];

        $query = mysqli_query($con, "SELECT name FROM artists WHERE id='$artistId'");

        $resultArray = mysqli_fetch_array($query);

        echo json_encode($resultArray);
    }

?>