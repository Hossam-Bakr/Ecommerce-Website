

<?php 

session_start();// start session 

unset($_SESSION);// unset session 
session_destroy();// destroy session 
header('Location:login.php');// move to login form
exit();