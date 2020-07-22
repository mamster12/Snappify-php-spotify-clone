<?php 
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name) {
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="assets/images/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="assets/images/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="assets/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <title>Welcome to Snappify</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">
    <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  <script src="assets/js/register.js"></script>
</head>
<body>
    <?php 
        if(isset($_POST['register-button'])){
            echo '<script>
                    $(document).ready(function() {
                        $("#login-form").hide();
                        $("#register-form").show();
                    });
                  </script>';
        } else {
            echo '<script>
                    $(document).ready(function() {
                        $("#login-form").show();
                        $("#register-form").hide();
                    });
                  </script>';
        }
    ?>

    <div id="background">
        <header> 
            <nav>
                <a href="register.php"><img class="main-logo" alt="logo" src="assets/images/logo/snappify_logo.png">Snappify.</a>
            </nav>
        </header>
        <div id="login-container">
            <div id="input-container">
                <form id="login-form" action="register.php" method="POST">
                    <h2>Login to your account</h2>
                <p>
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <label for="login-username">Username</label>
                <input type="text" id="login-username" name="login-username" placeholder="e.g johndoe" value="<?php getInputValue('login-username'); ?>" required>
                </p> 
                <p>
                <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="login-password"  required>
                    </p>
                    <button type="submit" name="login-button">Log in</button>

                    <div class="has-account-text">
                        <a href="#">
                            <span id="hide-login">Don't have an account yet? Sign up here.</span>
                        </a>
                    </div>
                </form>


                <form id="register-form" action="register.php" method="POST">
                    <h2>Create your free account</h2>
                <p>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="e.g Johndoe" value="<?php getInputValue('username'); ?>" required>
                </p> 
                <p>
                <?php echo $account->getError(Constants::$firstnameCharacters); ?>
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="e.g John" value="<?php getInputValue('firstname'); ?>" required>
                </p> 
                <p>
                <?php echo $account->getError(Constants::$lastnameCharacters); ?>
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="e.g Doe" value="<?php getInputValue('lastname'); ?>" required>
                </p> 
                <p>
                <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="e.g johndoe@gmail.com" value="<?php getInputValue('email'); ?>" required>
                </p> 
                <p>
                <label for="email2">Confirm Email</label>
                <input type="email" id="email2" name="email2" placeholder="e.g johndoe@gmail.com" value="<?php getInputValue('email2'); ?>" required>
                </p> 
                <p>
                <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                <?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
                <?php echo $account->getError(Constants::$passwordCharacters); ?>
                <label for="password">Password</label>
                    <input type="password" id="password" name="password" value="<?php getInputValue('password'); ?>" required>
                    </p>
                    <p>
                <label for="password2">Confirm Password</label>
                    <input type="password" id="password2" name="password2" value="<?php getInputValue('password2'); ?>" required>
                    </p>
                    <button type="submit" name="register-button">Sign Up</button>

                    <div class="has-account-text">
                        <a href="#">
                            <span id="hide-register">Already have an account? Log in here.</span>
                        </a>
                    </div>
                </form>
            </div>


            <!-- right section -->
            <div id="login-text">
                <h1>Get cool music, right now</h1>
                <h2>Listen to collections of songs for free.</h2>
                <ul>
                    <li>Discover new music you'll fall in love with</li>
                    <li>Craft your own Collection</li>
                    <li>Follow artists and keep up to date</li>
                </ul>
            </div>

        </div>
    </div>
</body>
</html>