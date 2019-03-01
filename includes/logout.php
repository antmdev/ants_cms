<?php  ob_start(); ?>
<?php session_start(); ?>

<?php 

// cancel the users session by assigning a boolean value of null 
//this assigns "fully nothing" not even a string and cancels the session
$_SESSION['username'] = null; 
$_SESSION['user_firstname'] = null;
$_SESSION['user_lastname'] = null;
$_SESSION['user_role'] = null;

header("location: /cms/index");
?>
 