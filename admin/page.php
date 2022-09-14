


<?php 

    $do = isset($_GET['do'])?  $_GET['do'] : 'manage'  ;
  


    if ($do == 'manage') {
        echo 'welcome to mange page ' ;
        echo '<a href="page.php?do=add" > go to add page </a>';
    }
    elseif ($do== 'insert'){
        echo 'welcome to insert page ';

    }
    elseif ($do== 'add'){
        echo 'welcome to add page ';
        echo '<a href="page.php?do=manage" > back to manage page </a>';

    }
    elseif ($do== 'delete'){
        echo 'welcome to delete page ';

    } 
    elseif ($do== 'update'){
        echo 'welcome to update page ';

    }else {
        echo "error there's no page with this name ";
    }