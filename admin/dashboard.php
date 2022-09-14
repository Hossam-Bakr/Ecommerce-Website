<?php


session_start();
$pageTitle = 'dashboard';


//----==== start init (connect , lang , header , navbar ,pageTitle)  ====-----
include "init.php";
global $tpl;
global $con;
//----==== end init (connect , lang , header , navbar ,pageTitle)  ====-----


//----------======= body of page ========-------------

if (isset($_SESSION['username'])) {
    // start dashboard page
    ?>

    <div class="main-stats">
        <div class="container text-center ">
            <h1>Dashboard Control</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat Total_members  ">
                        <i class="fa fa-users dashboard-icon"></i>
                        <div class="info">
                            <h5> Total members </h5>
                            <span> <a href="member.php"> <?php echo getCountOfRows("user_id", "users") ?> </a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat Pinding_members ">
                        <i class="fa fa-user-plus dashboard-icon"></i>
                        <div class="info ">
                            <h5> Pending members </h5>
                            <span> <a href="member.php?do=manage&page=pending"> <?php echo checkItemFound('reg_status', 'users', 0) ?>  </a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat Total_items">
                        <i class="fa fa-tag dashboard-icon"></i>
                        <div class="info">
                            <h5> Total Items </h5>
                            <span> <a href="Items.php"> <?php echo getCountOfRows("item_id", "items") ?> </a></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat Total_comments">
                        <i class="fa fa-comments dashboard-icon"></i>
                        <div class="info">
                            <h5> Total comments </h5>
                            <span>  <a href="Comments.php"> <?php echo getCountOfRows("c_id", "comments") ?> </a> </span>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
    <!--     start panel card-->
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="card my-3">
                    <div class="card-header">
                        <?php $limitOfusers = 5; ?>
                        <span class="h5"> <span>  <i
                                        class="fa fa-users fs-4 mx-1 fa-fw "></i> </span>Latest <?php echo $limitOfusers; ?> Rigisterd Users </span>
                        <span class="plus-minus-toggle">
                            <i class="fa fa-plus fa-pull-right fa-fw mt-1 "></i>
                     </span>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <?php
                            $arrayUsers = getLatest("*", 'users', 'user_id', $limitOfusers);
                            if (!empty($arrayUsers)) {
                                echo '<ul class="list-unstyled list-users "> ';
                                foreach ($arrayUsers as $arrayUser) {
                                    echo "<li> ";
                                    echo $arrayUser['user_name'];
                                    echo " <a href='member.php?do=edit&user_id=" . $arrayUser["user_id"] . "' ><span class='btn btn-success fa-pull-right btn-sm'> <i class='fa fa-edit'></i> Edit</span></a> ";

                                    if ($arrayUser['reg_status'] == 0) {
                                        $id = $arrayUser["user_id"];
                                        echo " <button class='btn btn-info fa-pull-right btn-sm'><a class='text-decoration-none text-light' href='member.php?do=activate&user_id=$id'> <i class='fa-solid fa-check fa-fw'></i> Activate </a></button> ";
                                    }

                                    echo "</li> ";

                                }
                                echo '</ul>';
                            } else {
                                echo '<div class="nice-message" >  there is no members  </div>';

                            }
                            ?>
                        </blockquote>
                    </div>
                </div>
                <?php
                if (empty($arrayUsers)) {
                    echo '<button class="btn btn-primary "><a href="member.php?do=add" class=" text-light text-decoration-none"> <i
                                            class="fa-solid fa-circle-plus fa-fw"></i> new member </a></button> ';
                }
                ?>
            </div>
            <div class="col-sm-6">
                <div class="card my-3">
                    <div class="card-header">
                        <span class="h5"> <i class="fa fa-tag fs-4 mx-1 fa-fw "></i>latest items </span>
                        <span class="plus-minus-toggle">
                            <i class="fa fa-plus fa-pull-right fa-fw mt-1 "></i>
                         </span>
                        <?php $limitOfItems = 5; ?>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <?php
                            $arrayItems = getLatest("*", 'items', 'item_id', $limitOfItems);
                            if (!empty($arrayItems)) {
                                echo '<ul class="list-unstyled list-users "> ';
                                foreach ($arrayItems as $item) {
                                    echo "<li> ";
                                    echo $item['item_name'];
                                    echo " <a href='Items.php?do=edit&item_id=" . $item["item_id"] . "' ><span class='btn btn-success btn-sm fa-pull-right'> <i class='fa fa-edit'></i> Edit</span></a> ";

                                    if ($item['approve'] == 0) {
                                        $id = $item["item_id"];
                                        echo " <button class='btn btn-info fa-pull-right btn-sm'><a class='text-decoration-none text-light' href='Items.php?do=approve&item_id=$id'> <i class='fa-solid fa-check '></i> Activate </a></button> ";
                                    }

                                    echo "</li> ";

                                }
                                echo '</ul>';
                            } else {
                                echo '<div class="nice-message" >  there is no such items   </div>';

                            }
                            ?>
                        </blockquote>
                    </div>
                </div>
                <?php
                if (empty($arrayItems)) {
                    echo '<button class="btn btn-primary "><a href="Items.php?do=add" class=" text-light text-decoration-none"> <i
                                            class="fa-solid fa-circle-plus fa-fw"></i> new item </a></button> ';
                }
                ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card my-3">
                    <div class="card-header">
                        <?php $limitOfComments = 5; ?>
                        <span class="h5"> <span>  <i
                                        class="fa fa-comment fs-4 mx-1 fa-fw "></i> </span>Latest <?php echo $limitOfComments; ?> Comments </span>
                        <span class="plus-minus-toggle">
                            <i class="fa fa-plus fa-pull-right fa-fw mt-1 "></i>
                     </span>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote p-2">
                            <?php
                            $stmt = $con->prepare("SELECT 
                                                       comments.* , users.user_name
                                               FROM 
                                                       comments 
                                               INNER JOIN 
                                                       users 
                                               ON
                                                       comments.user_id = users.user_id
                                           
                                                  limit 5  ");
                            $stmt->execute();
                            $comments = $stmt->fetchAll();

                            if (!empty($comments)) {
                                foreach ($comments as $comment) {
                                    echo '<div class="comment-container d-flex flex-wrap mt-2 mb-3 " > ';
                                    echo '<span class="comment-n">' . $comment['user_name'] . '</span>';
                                    echo '<div class="comment-c p-2 rounded ">' . $comment['comment'] . '</div>';
                                    echo '</div> ';
                                }
                            } else {
                                echo '<div class="nice-message" >  there is no such items   </div>';

                            }
                            ?>
                        </blockquote>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!--     end  panel card -->

    <?php
    // end dashboard page


} else {
    header('Location:index.php');
    exit();
}

//----------======= end body of page ========-------------


//----------======= start footer  ========-------------
include $tpl . "footer.php";
//----------======= end footer  ========-------------

?>



