<?php
ini_set('display_errors' , 'on') ;
error_reporting(E_ALL);
// -------------- ==== routes ==== ---------------
$tpl = "includes/templates/";
$langs = "includes/langs/";
$funcs = "includes/functions/";
$css = "layout/css/";
$js = "layout/js/";

// -------------- ==== end routes ==== ---------------
$userSession = '' ;
if (isset($_SESSION['user'])){
    $userSession = $_SESSION['user'] ;
}

// -------------- ==== includes  ==== ---------------

// language
include $langs . "english.php";
include "admin/connect.php";             //  connection to database

include $funcs . "functions.php";
include $tpl . "header.php";       // header

// -------------- ==== end includes ==== ---------------

     

