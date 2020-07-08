<?php 

    if(isset($_POST['login-button'])) {
        // Login Button was pressed
        $username = $_POST['login-username'];
        $password = $_POST['login-password'];

        //Login function
        $result = $account->login($username, $password);

        // redirect if true
        if($result){
            $_SESSION['userLoggedIn'] = $username;
            header("Location: index.php");
        }
    }

?>