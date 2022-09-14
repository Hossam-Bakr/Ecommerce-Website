<?php 
     
// -------------- ==== routes ==== ---------------
     $tpl = "includes/templates/";
     $langs="includes/langs/";
     $funcs="includes/functions/";
     $css = "layout/css/";
     $js = "layout/js/";
// -------------- ==== end routes ==== ---------------





// -------------- ==== includes  ==== ---------------


     include $langs."english.php";      // language 
     include $funcs . "functions.php";
     include "connect.php";             //  connection to database 
     include $tpl . "header.php";       // header 

     if (!isset($noNavbar)) {           // ----------------
          include $tpl . "navbar.php";  // ----navbar ----
     }                                  // -----------------

// -------------- ==== end includes ==== ---------------

     

