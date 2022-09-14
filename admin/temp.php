<?php

/*
 ==========================================
 ==== edit members
 ==== add |remove |update members
 ==========================================

 */
ob_start();
session_start();
$pageTitle = 'Categories';
//----==== start init (connect , lang , header , navbar ,pageTitle)  ====-----
include "init.php";
//----==== end init (connect , lang , header , navbar ,pageTitle)  ====-----


global $con;
global $tpl;

if (isset($_SESSION['username'])) {


    //----------======= body of page ========-------------
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';


    // ---------- ............. start of manage page ......... --------- \\
    if ($do == 'manage') {

    }
    // ---------- ............. end of manage page ......... --------- \\


    // ---------- ............. start of edit page ......... --------- \\

    else if ($do == 'edit') {
    }
    // ---------- ............. end of edit page ......... --------- \\
    // ---------- ............. start of update page ......... --------- \\

    elseif ($do == 'update') {


    }
    // ---------- ............. end of update page ......... --------- \\


    // ---------- ............. start of add page ......... --------- \\
    elseif ($do == "add") {
    } // ---------- ............. end of add page ......... --------- \\


    // ---------- ............. start of insert page ......... --------- \\

    elseif ($do == "insert") {
    }

    // ---------- ............. end of delete page ......... --------- \\


    //----------======= end body of page ========-------------


    //----------======= start footer  ========-------------
    include $tpl . "footer.php";
    //----------======= end footer  ========-------------


} else {
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>