
<?php include('../config/constants.php'); ?>

<?php
//Check whether the user is logged in or not

if(!isset($_SESSION['user'])){
    //User is not logged in
    $_SESSION['no-login-message'] = '<div class="error">Please Login to access Admin Panel.</div>';
    header('location:'.SITEURL.'admin/login.php');
}
