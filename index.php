<?php 
    include("includes/config.php");
    
    // session_destroy();
    if(isset($_SESSION['userLoggedIn'])){
        $userLoggedIn = $_SESSION['userLoggedIn'];
    } else {
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Snappify</title>
</head>
<body>
    <h1>Hello World!</h1>
</body>
</html>