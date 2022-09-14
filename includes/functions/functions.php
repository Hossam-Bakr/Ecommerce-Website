<?php


// =================  ------------- start front end functions  ------------   ===============\\

/*
 * function to check if user activated or no
 * check if the reg_status of the user is equal to 0 or 1
 * return 1 if user activated and 0 otherwise
 */

function getItems($where , $value ){
       global  $con ;
       $stmt= $con->prepare("SELECT * FROM items WHERE  $where = ? ORDER BY item_id ASC ");
       $stmt->execute(array($value)) ;
       $items= $stmt ->fetchAll();
       return $items ;
   }



/*
* function to check if user activated or no
* check if the reg_status of the user is equal to 0 or 1
* return 1 if user activated and 0 otherwise
*/

function getComments($where , $value ){
    global  $con ;
    $stmt= $con->prepare("SELECT comment FROM comments WHERE  $where = ? ORDER BY item_id ASC ");
    $stmt->execute(array($value)) ;
    $comments= $stmt ->fetch();
    return $comments ;
}


/*
 * function to check if user activated or no
 * check if the reg_status of the user is equal to 0 or 1
 * return 1 if user activated and 0 otherwise
 */

function checkUserStatus($user ) {
    global $con ;
    $stmtx = $con->prepare("SELECT 
            user_name , reg_status
            FROM 
                users
            WHERE 
                user_name = ? 
            AND 
                reg_status = 0 
    " ) ;
    $stmtx->execute(array($user));
    return $stmtx->rowCount() ;
}






// =================  -------------end front end functions  ------------   ===============\\








//--------------------back end














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

















