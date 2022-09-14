<?php

/*
 ==========================================
 ==== edit members
 ==== add |remove |update members
 ==========================================

 */
session_start();
$pageTitle = 'Comments';
//----==== start init (connect , lang , header , navbar ,pageTitle)  ====-----
include "init.php";
//----==== end init (connect , lang , header , navbar ,pageTitle)  ====-----


global $con;
global $tpl;
if (isset($_SESSION['username'])) {


    //----------======= body of page ========-------------
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';


    // ---------- ............. start of manage page ......... --------- \\

    if ($do == 'manage') { ?>

        <?php
        // fetch data from data base
        $stmt = $con->prepare("SELECT 
                                               comments.* , users.user_name , items.item_name 
                                       FROM 
                                               comments 
                                       INNER JOIN 
                                               users 
                                       ON
                                               comments.user_id = users.user_id
                                       INNER JOIN 
                                                items 
                                       ON 
                                                comments.item_id=  items.item_id
                                            ");
        $stmt->execute();
        $comments= $stmt->fetchAll();

if (!empty($comments)) {
        ?>
        <h1 class="title text-center my-4"> Comments </h1>

        <div class="container">
            <div class="table-responsive table-bordered">
                <table class="table text-center main-table">
                    <tr>
                        <th>ID</th>
                        <th>Comment</th>
                        <th> Item Name</th>
                        <th> User Name</th>
                        <th> Added Date</th>
                        <th> control</th>
                    </tr>
                    <tbody>
                    <?php
                    foreach ($comments as $comment) {
                        ?>

                        <tr>
                            <td><?php echo $comment['c_id'] ?></td>
                            <td><?php echo $comment['comment'] ?></td>
                            <td><?php echo $comment['item_name'] ?></td>
                            <td><?php echo $comment['user_name'] ?></td>
                            <td><?php echo $comment['c_date'] ?></td>

                            <td>
                                <button class="btn btn-success btn-sm "><a class="text-decoration-none text-light"
                                                                           href="?do=edit&comment_id=<?php echo $comment['c_id'] ?>">
                                        <i class="fa fa-edit fa-fw"> </i> Edit</a></button>
                                <button class="btn btn-danger btn-sm"><a class="text-decoration-none text-light confirm"
                                                                         href="?do=delete&comment_id=<?php echo $comment['c_id'] ?>"><i
                                                class="fa-solid fa-trash fa-fw"></i> Delete </a></button>
                                <?php
                                if ($comment['status'] == 0) {
                                    $id = $comment["c_id"];
                                    echo " <button class='btn btn-info btn-sm '><a class='text-decoration-none text-light' href='?do=approve&comment_id=$id' <i class='fa-solid fa-check fa-fw'></i> Approve </a></button> ";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>


                </table>
            </div>


        </div>


    <?php

    } else{
    echo '<div class="container mt-3 " > ';
    echo '<div class="nice-message" >  there is no such comments   </div>';

    echo ' </div>';
}
}
    // ---------- ............. end of manage page ......... --------- \\


    // ---------- ............. start of edit page ......... --------- \\

    else if ($do == 'edit') {
        if (isset($_GET['comment_id']) && is_numeric(intval($_GET['comment_id']))) {

            $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
            $stmt->execute(array($_GET['comment_id']));
            $comment = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {

                ?>

                <h1 class="edit text-center my-5">Edit Comment </h1>

                <div class="container d-flex justify-content-center align-items-center">
                    <form class="col-sm-10 col-md-7 h-50 p-3 border border-1 border-dark rounded-2  " method="POST"  action="?do=update">
                        <label class="fs-4">Comment </label>
                        <textarea name="comment"  class="form-control"> <?php echo $comment['comment']?></textarea>
                        <input type="hidden" name="input_id" value="<?php echo $comment['c_id'] ?>">

                        <input id="subBtn" type="submit" class="btn btn-primary my-2" name="submitBtn"
                               value="update">
                    </form>
                </div>



                <?php
            } else {
                echo '<div class="container" > ';
                $theMsg = '<div class=" alert my-2 alert-danger " > "wrong id of user "</div>';
                redirct($theMsg);
                echo '</div>';

            }
        }
    }

    // ---------- ............. end of edit page ......... --------- \\


    // ---------- ............. start of delete page ......... --------- \\

    elseif ($do == 'delete') {
        echo '<div class="container " >';
        $cid = $_GET['comment_id'] ;
        if (isset($_GET['comment_id']) && is_numeric(intval($_GET['comment_id']))) {
            // check found in database or no
            $check = checkItemFound('c_id', 'comments', $_GET['comment_id']);

            if ($check > 0) {
                $stmt = $con->prepare("DELETE FROM comments WHERE c_id = ? ");
                $stmt->execute(array(  $cid ));
                $theMsg = "<div class='alert alert-success my-3'>  $check row deleted  </div> ";
                redirct($theMsg, 'back');
            } else {
                $theMsg = '<div class="alert-danger alert " > wrong id of user  </div>';
                redirct($theMsg);
            }
        }
        echo '</div> ';
    }

    // ---------- ............. end of delete page ......... --------- \\


    // ---------- ............. start of update page ......... --------- \\

    elseif ($do == 'update') {

        echo '<h1 class="text-center my-4 fw-bold"> Update Comment  </h1>';
        echo '<div class="container"> ';
        if (isset($_POST['submitBtn'])) {


            $comment_id = $_POST['input_id'];
            $comment = $_POST['comment'];

            $stmt = $con->prepare("UPDATE comments SET comment=?  WHERE c_id=?");
            $stmt->execute(array($comment, $comment_id));
            $count = $stmt->rowCount();
            if ($count > 0 ){
                $theMsg = "<div class='alert alert-success' >   $count record updated   </div> ";
                redirct($theMsg, "back");
            }

        } else {
            $theMsg = ' <div class="alert alert-danger">you cant access this page </div>  ';
            redirct($theMsg);

        }
        echo '</div> ';
    } // ---------- ............. end of update page ......... --------- \\


    elseif ($do == 'approve') {
        echo '<div class="container " >';
        if (isset($_GET['comment_id']) && is_numeric(intval($_GET['comment_id']))) {
            // check found in database or no
            $id = $_GET['comment_id'];
            $check = checkItemFound('c_id', 'comments', $id);

            if ($check > 0) {
                $stmt = $con->prepare("UPDATE comments SET status=1 WHERE c_id= ?");

                $stmt->execute(array($id));
                $theMsg = "<div class='alert alert-success my-3'>  $check row updated   </div> ";
                redirct($theMsg, 'back');
            } else {
                $theMsg = '<div class="alert-danger alert " > wrong id of user  </div>';
                redirct($theMsg);
            }
        }
        echo '</div> ';

    }


    //----------======= end body of page ========-------------


    //----------======= start footer  ========-------------
    include $tpl . "footer.php";
    //----------======= end footer  ========-------------


} else {
    header('Location:index.php');
    exit();
}
?>