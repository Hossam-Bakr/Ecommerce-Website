<?php
session_start();
global  $tpl;
global  $con ;
$pageTitle = 'Home';
include "init.php";
print_r($_SESSION);




include $tpl . "footer.php";
?>