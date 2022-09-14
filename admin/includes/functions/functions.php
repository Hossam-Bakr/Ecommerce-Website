<?php 

function getTitle (){
    global $pageTitle; 
    if ( isset($pageTitle)){
        echo $pageTitle ; 
    }
    else{
        echo  'default';
    };
}


/* =======================================================================
 * ========function to redirect to previous page or home page ======== v.02
 =========================================================================  */

function redirct($message  ,$url= null ,$seconds =1 ) {

  if ($url === null){
     $url= 'index.php' ;
     $link = "HomePage" ;
  }

  else{
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '' ){
            $url =$_SERVER['HTTP_REFERER'] ;
            $link ="previous page " ;
        }
        else {
            $url= 'index.php' ;
            $link = "HomePage" ;
        }
  }
    echo  $message;
    echo    "  <div class='alert alert-success my-3'> you will be redirected to the $link after   $seconds  seconds </div> " ;
    header("refresh:$seconds; url=$url");
    exit();
}




/* =========================================================================
 * ========function to check if cell  in row  in database found or not found
 =========================================================================  */

function checkItemFound ( $select , $from ,$value ){
   global $con;
   $statement =$con->prepare("SELECT $select FROM $from WHERE $select =? ") ;
   $statement->execute(array($value) ) ;
   $count = $statement->rowCount();
   return $count ;
}


/* =========================================================================
 * ========function to get count of column cells in database
 =========================================================================  */

function getCountOfRows ( $item , $table ){
    global $con ;
    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table") ;
    $stmt2->execute();
    return $stmt2->fetchColumn() ;
}

/* =========================================================================
 * ========function to get latest number of columns in database
 =========================================================================  */
function getLatest( $select , $table , $order , $limit = 5 ){
    global  $con ;
    $getStatement = $con->prepare("SELECT $select FROM $table Order BY $order DESC limit $limit");
    $getStatement->execute() ;
    $rowElements= $getStatement ->fetchAll();
    return $rowElements ;

}

















