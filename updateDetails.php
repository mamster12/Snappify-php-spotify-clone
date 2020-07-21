<?php 
include("includes/includedFiles.php");
?>

<div class="user-details">
    <div class="container border-bottom">
        <h2>EMAIL</h2>
        <input type="text" name="email" class="email" placeholder="Email Address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">SAVE</button>
    </div>

    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" name="old-password" class="old-password" placeholder="Current password">
        <input type="password" name="new-password1" class="new-password1" placeholder="New password">
        <input type="password" name="new-password2" class="new-password2" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('old-password', 'new-password1', 'new-password2')">SAVE</button>
    </div>
</div>