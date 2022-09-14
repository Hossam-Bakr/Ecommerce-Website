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
        $sort = 'asc';
        $orderingArray = ['asc', 'desc'];
        if (isset($_GET['sort']) && in_array($_GET['sort'], $orderingArray)) {
            $sort = $_GET['sort'];
        }

        $stmt = $con->prepare("SELECT * FROM categories ORDER BY ordering $sort");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        if ($categories){
        ?>

        <div class="container categoryManage">
            <h1 class="mb-5 mt-3  text-center ">Category Control</h1>
            <div class="card my-3">
                <div class="card-header">
                    <span class="h6 manageCatsTitle" > <i class="fa fa-edit fa-1x fa-fw"></i> Manage categories  </span>
                    <div class="fa-pull-right">
                        <i class="fa fa-sort"></i> ordering :[
                        <a class="<?php if ($sort == 'asc') {
                            echo 'active';
                        } ?>" href="?sort=asc">Asc | </a>
                        <a class="<?php if ($sort == 'desc') {
                            echo 'active';
                        } ?>" href="?sort=desc">Desc</a>
                        ]
                        <i class="fa fa-eye ms-2"></i> View :[
                        <span class="view" data-view="full">full | </span>
                        <span data-view = "classic" class="view">classic </span>
                        ]
                    </div>
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <?php
                        foreach ($categories as $category) {

                            echo '<div class="cat"> ';
                                echo '<div class="categoriesBtns"> ';
                                echo '<a href="?do=edit&cat_id=' . $category['id'] . '"  class="btn btn-info "  > <i class="fa fa-edit"></i> Edit</a>  ';
                                echo '<a href="?do=delete&cat_id=' .$category['id']. '" class="btn btn-danger "  > <i class="fa fa-close"></i> Delete</a>  ';
                                echo '</div> ';
                            echo "<h5>" . $category['name'] . " </h5>";
                                    echo '<div class="full-view"> ' ;
                                    echo "<p> " . $category['description'] . " </p>";
                                    if ($category['visibility'] == 1) {
                                        echo "<span class='badge bg-danger me-2 '> <i class='fa fa-eye fa-fw' > </i> hidden </span>";
                                    }
                                    if ($category['allow_comment'] == 1) {
                                        echo "<span class='badge bg-primary me-2 '>  <i class='fa fa-close fa-fw'  > </i> comment disabled </span>";
                                    }
                                    if ($category['allow_ads'] == 1) {
                                        echo "<span class='badge bg-dark me-2  '>  <i class='fa fa-close fa-fw' > </i> ads disabled </span>";
                                    }
                                    echo '</div> ';
                            echo '</div> ';
                        }
                        ?>

                    </blockquote>
                </div>
            </div>

            <button class="btn btn-primary btn-sm "><a href="?do=add" class=" text-light text-decoration-none"> <i
                            class="fa-solid fa-circle-plus fa-fw"></i> New Category  </a></button>

        </div>

        <?php
        }
        else {
            echo '<div class="container mt-3 " > ' ;
            echo '<div class="nice-message" >  there is no such items   </div>';
            echo ' 
            <button class="btn btn-primary btn-sm "><a href="?do=add" class=" text-light text-decoration-none"> <i
                            class="fa-solid fa-circle-plus fa-fw"></i> New Category  </a></button>' ;
            echo ' </div>' ;
        }
    }
    // ---------- ............. end of manage page ......... --------- \\


    // ---------- ............. start of edit page ......... --------- \\

    else if ($do == 'edit') {
        if (isset($_GET['cat_id']) && is_numeric(intval($_GET['cat_id']))) {

            $stmt = $con->prepare("SELECT * FROM categories WHERE id = ? ");
            $stmt->execute(array($_GET['cat_id']));
            $catRow = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {

                ?>
                <h1 class="edit text-center my-3">Update Category </h1>

                <div class="container d-flex justify-content-center align-items-center">
                    <form class="col-sm-10 col-md-7 h-50 p-3 shadow-lg rounded-2  " method="POST" action="?do=update">
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                            <label class="fs-5 col-md-2">Name </label>
                            <input type="text" class="form-control-lg border-0 col-md-10"
                                   value="<?php echo $catRow['name'] ?>"
                                   name="name" placeholder="enter the name of category ">

                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                            <label class="fs-5  col-md-2">Description </label>
                            <input type="text" class="form-control-lg border-0  col-md-10" name="description"
                                   value="<?php echo $catRow['description'] ?>"
                                   placeholder="enter the description of category ">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $catRow['id'] ?>">
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center  ">

                            <label class=" fs-5 col-md-2 ">Ordering </label>
                            <input type="text" class="form-control-lg border-0 col-md-10 " name="ordering"
                                   value="<?php echo $catRow['ordering'] ?>"
                                   placeholder="enter number of ordering page  ">

                        </div>
                        <div class="input-container mb-2  w-100 d-flex  align-items-center ">

                            <label class=" fs-5 col-md-4 "> Visible </label>
                            <div class="col-md-8 d-flex">
                                <div class="me-2">
                                    <input id="vis-yes" type="radio" name="visible"
                                           value="0" <?php if ($catRow['visibility'] == 0) {
                                        echo 'checked';
                                    } ?> >
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visible"
                                           value="1" <?php if ($catRow['visibility'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                    <label for="vis-no"> No</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center">

                            <label class=" fs-5 col-md-4 "> Allow_Comments </label>
                            <div class="col-md-8 d-flex">
                                <div class="me-2">
                                    <input id="comment-yes" type="radio" name="allow_comments"
                                           value="0" <?php if ($catRow['visibility'] == 0) {
                                        echo 'checked';
                                    } ?>>
                                    <label for="comment-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="comment-no" type="radio" name="allow_comments"
                                           value="1" <?php if ($catRow['visibility'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                    <label for="comment-no"> No </label>
                                </div>
                            </div>
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center">

                            <label class=" fs-5 col-md-4"> Allow_Ads </label>
                            <div class="col-md-8 d-flex">
                                <div class="me-2">
                                    <input id="ads-yes" type="radio" name="allow_ads"
                                           value="0" <?php if ($catRow['visibility'] == 0) {
                                        echo 'checked';
                                    } ?>>
                                    <label for="ads-yes"> Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="allow_ads"
                                           value="1" <?php if ($catRow['visibility'] == 1) {
                                        echo 'checked';
                                    } ?>>
                                    <label for="ads-no"> No</label>
                                </div>
                            </div>
                        </div>

                        <input id="subBtn" type="submit" class="btn btn-primary my-2" name="submitBtn"
                               value="Save">
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
    // ---------- ............. start of update page ......... --------- \\

    elseif ($do == 'update') {
        echo '<div class="container " > ';
        echo '<h2 class="text-center" >Update Page</h2> ';
        if (isset($_POST['submitBtn'])) {
                $id = $_POST['id'];
                $name = $_POST['name'];
                $desc = $_POST['description'];
                $order = $_POST['ordering'];
                $visible = $_POST['visible'];
                $comment = $_POST['allow_comments'];
                $ads = $_POST['allow_ads'];

                $catstmt = $con->prepare("UPDATE 
                                                        categories 
                                                    SET  
                                                        name =? ,
                                                        description = ? , 
                                                        ordering = ? , 
                                                        visibility = ? ,
                                                        allow_comment= ? ,
                                                        allow_ads = ? 
                                                    WHERE 
                                                        id = ? 
                                                        
                                                        
                    ");
                $catstmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));
                $catCountRows =$catstmt->rowCount() ;
                if ($catCountRows > 0 ){

                    $theMsg = "<div class='alert alert-success' >   $catCountRows record updated   </div> ";
                    redirct($theMsg, "back" );


                } else {
                    $theMsg = ' <div class="alert alert-danger">you can not access this page directly</div>  ';
                    redirct($theMsg);

                }

            }

        echo '</div> ';

    }
    // ---------- ............. end of update page ......... --------- \\


    // ---------- ............. start of add page ......... --------- \\
    elseif ($do == "add") {
        ?>
        <h1 class="edit text-center my-3">Add Category </h1>
        <div class="container d-flex justify-content-center align-items-center">
            <form class="col-sm-10 col-md-7 h-50 p-3 shadow-lg rounded-2  " method="POST" action="?do=insert">
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                    <label class="fs-5 col-md-2">Name </label>
                    <input type="text" class="form-control-lg border-0 col-md-10" required="required"
                           name="name" placeholder="enter the name of category ">

                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                    <label class="fs-5  col-md-2">Description </label>
                    <input type="text" class="form-control-lg border-0  col-md-10" name="description"
                           placeholder="enter the description of category ">
                </div>
                <input type="hidden" name="input_id" required="required"/>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center  ">

                    <label class=" fs-5 col-md-2 ">Ordering </label>
                    <input type="text" class="form-control-lg border-0 col-md-10 " name="ordering"
                           placeholder="enter number of ordering page  ">

                </div>
                <div class="input-container mb-2  w-100 d-flex  align-items-center ">

                    <label class=" fs-5 col-md-4 "> Visible </label>
                    <div class="col-md-8 d-flex">
                        <div class="me-2">
                            <input id="vis-yes" type="radio" name="visible" vlaue="0" checked>
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visible" value="1">
                            <label for="vis-no"> No</label>
                        </div>
                    </div>
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center">

                    <label class=" fs-5 col-md-4 "> Allow_Comments </label>
                    <div class="col-md-8 d-flex">
                        <div class="me-2">
                            <input id="comment-yes" type="radio" name="allow_comments" value="0" checked>
                            <label for="comment-yes">Yes</label>
                        </div>
                        <div>
                            <input id="comment-no" type="radio" name="allow_comments" value="1">
                            <label for="comment-no"> No </label>
                        </div>
                    </div>
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center">

                    <label class=" fs-5 col-md-4"> Allow_Ads </label>
                    <div class="col-md-8 d-flex">
                        <div class="me-2">
                            <input id="ads-yes" type="radio" name="allow_ads" value="0" checked>
                            <label for="ads-yes"> Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="allow_ads" value="1">
                            <label for="ads-no"> No</label>
                        </div>
                    </div>
                </div>

                <input id="subBtn" type="submit" class="btn btn-primary my-2" name="submitBtn"
                       value="Add Category">
            </form>
        </div>


        <?php

    } // ---------- ............. end of add page ......... --------- \\


    // ---------- ............. start of insert page ......... --------- \\

    elseif ($do == "insert") {

        echo '<h1 class="text-center my-4 fw-bold"> Insert Category </h1>';
        echo '<div class="container"> ';

        if (isset($_POST['submitBtn'])) {


            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visible = $_POST['visible'];
            $comment = $_POST['allow_comments'];
            $ads = $_POST['allow_ads'];


            $check = checkItemFound("name", "categories", $name);
            if ($check == 1) {
                $theMsg = " <div class='alert alert-danger' > sorry this name category is found  </div>";

                redirct($theMsg, 'back');

            } else {
                $stmt = $con->prepare("INSERT INTO 
                                             categories(name,description,ordering,	visibility, allow_comment ,allow_ads ) 
                                                VALUES
                                                    (:zname,:zdesc,:zorder,:zvis , :zcomment , :zads) ");
                $stmt->execute(
                    array(

                        'zname' => $name,
                        'zdesc' => $desc,
                        'zorder' => $order,
                        'zvis' => $visible,
                        'zcomment' => $comment,
                        'zads' => $ads
                    )
                );
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $theMsg = " <div class='alert alert-success'>$count category inserted  </div>";

                    redirct($theMsg, 'back');
                }
            }

        } else {
            echo '<div class="container " >';
            $theMsg = '<div class="alert alert-danger">  you can not access this page </div>';
            redirct($theMsg);
            echo '</div>';
        }
        echo '</div> ';
    }
    // ---------- ............. end of insert page ......... --------- \\


    // ---------- ............. start of delete page ......... --------- \\

    elseif ($do == 'delete') {

        echo '<div class="container " >';
        if (isset($_GET['cat_id']) && is_numeric(intval($_GET['cat_id']))) {
            // check found in database or no
            $check = checkItemFound('id', 'categories', $_GET['cat_id']);


            if ($check > 0) {
                $stmt = $con->prepare("DELETE FROM categories WHERE id = ? limit 1");
                $stmt->execute(array($_GET['cat_id']));
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