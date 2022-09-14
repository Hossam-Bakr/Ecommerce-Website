<?php
session_start();
global  $tpl;
global  $con ;
$pageTitle = 'Home';
include "init.php";?>

<?php
// ============-----------get data from database ---------=============\\
$items = getItems('cat_id',$_GET['catid']);
// ============-----------end get data from database ---------=============\\
?>

<div class="categories-items">
    <div class="container mt-3">
    <h1 class="text-center"> <?php echo str_replace('-' , ' ' ,$_GET['pagename'] ) ?></h1>
    <?php
    echo '<div class="row">' ;
       foreach ($items as $item) {

              echo '<div class="col-sm-6 col-md-3"> ' ;
                  echo  '<div class="item-data"> ' ;
                        echo '<span class="item-price">' . $item['price'] . '</span>';
                        echo '<img class="img-fluid"  src="avataaars.png" alt="not found image " >' ;
                       echo '<h3>'. $item['item_name'] .'</h3>'  ;
                       echo '<p> ' . $item['description'] .'</p>'  ;
                   echo '</div> ' ;
               echo '</div> ' ;

       }
    echo '</div> </div>' ;

    ?>


</div>


<?php include $tpl . "footer.php"; ?>