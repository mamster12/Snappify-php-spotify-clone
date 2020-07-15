<?php

    include("../../config.php"); // to enable database calls

    if(isset($_POST['songId'])) {
        $songId = $_POST['songId'];

        $query = mysqli_query($con, "UPDATE songs SET plays = plays + 1 WHERE id='$songId'");
    }
?> 