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
        ?>

        <?php
        // fetch data from data base

        $istmt = $con->prepare("SELECT 
                                             items.* , 
                                             categories.name , 
                                             users.user_name
                                        FROM
                                            items 
                                        INNER JOIN 
                                            categories 
                                        ON 
                                            items.cat_id = categories.id 
                                        INNER JOIN 
                                            users 
                                        ON 
                                            items.member_id = users.user_id ");
        $istmt->execute();
        $items = $istmt->fetchAll();
        $items= [] ;
        if (!empty($items)) {
            ?>
            <h1 class="title text-center my-4"> Manage Items </h1>

            <div class="container">
                <div class="table-responsive table-bordered">
                    <table class="table text-center main-table">
                        <tr>
                            <th>ID</th>
                            <th> Name</th>
                            <th> Description</th>
                            <th> Price</th>
                            <th> Add Date</th>
                            <th> country</th>
                            <th> Category</th>
                            <th> Member</th>
                            <th> control</th>

                        </tr>
                        <tbody>
                        <?php
                        foreach ($items as $item) {
                            ?>

                            <tr>
                                <td><?php echo $item['item_id'] ?></td>
                                <td><?php echo $item['item_name'] ?></td>
                                <td><?php echo $item['description'] ?></td>
                                <td><?php echo $item['price'] ?></td>
                                <td><?php echo $item['add_date'] ?></td>
                                <td><?php echo $item['country_made'] ?></td>
                                <td><?php echo $item['name'] ?></td>
                                <td><?php echo $item['user_name'] ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm"><a class="text-decoration-none text-light"
                                                                              href="?do=edit&item_id=<?php echo $item['item_id'] ?>">
                                            <i class="fa fa-edit fa-fw"> </i> Edit</a></button>
                                    <button class="btn btn-danger btn-sm "><a
                                                class="text-decoration-none text-light confirm"
                                                href="?do=delete&item_id=<?php echo $item['item_id'] ?>"><i
                                                    class="fa-solid fa-trash fa-fw"></i> Delete </a></button>
                                    <?php
                                    if ($item['approve'] == 0) {
                                        $id = $item["item_id"];
                                        echo " <button class='btn btn-info btn-sm'><a class='text-decoration-none ' href='?do=approve&item_id=$id' > <i class='fa-solid fa-check'> </i>  Approve </a></button> ";
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>


                    </table>
                </div>
                <button class="btn btn-primary btn-sm "><a href="?do=add" class=" text-light text-decoration-none"> <i
                                class="fa-solid fa-circle-plus fa-fw"></i> new Item </a></button>

            </div>


            <?php
        } else {
            echo '<div class="container mt-3 " > ';
            echo '<div class="nice-message" >  there is no such items   </div>';
            echo '<button class="btn btn-primary btn-sm "><a href="?do=add" class=" text-light text-decoration-none"> <i
                                class="fa-solid fa-circle-plus fa-fw"></i> new Item </a></button>' ;
            echo ' </div>';

        }
    }
    // ---------- ............. end of manage page ......... --------- \\


    // ---------- ............. start of edit page ......... --------- \\

    else if ($do == 'edit') {

        if (isset($_GET['item_id']) && is_numeric(intval($_GET['item_id']))) {
            $itemId = $_GET['item_id'];
            $stmt = $con->prepare("SELECT * FROM items where  item_id =?");
            $stmt->execute(array($itemId));
            $item = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {

                ?>

                <h1 class="edit text-center my-2">Edit Member </h1>
                <div class="container d-flex justify-content-center align-items-center flex-wrap ">
                    <form class="col-sm-10 col-md-7 h-50 p-3 shadow-lg rounded-2  position-relative " method="POST"
                          action="?do=update">
                        <input type="hidden" name="input_id" value="<?php echo $item['item_id'] ?>">
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                            <label class="fs-5 col-md-2">Name </label>
                            <input type="text" class="form-control-lg border-0 col-md-10"
                                   name="name" placeholder="enter the name of Item "
                                   value="<?php echo $item['item_name'] ?>">
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative">
                            <label class="fs-5 col-md-2">Description </label>
                            <input type="text" class="form-control-lg border-0 col-md-10"
                                   name="description" placeholder="enter the Description "
                                   value="<?php echo $item['description'] ?>">
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                            <label class="fs-5 col-md-2">Price </label>
                            <input type="text" class="form-control-lg border-0 col-md-10"
                                   name="price" placeholder="enter the Price of Item "
                                   value="<?php echo $item['price'] ?>">
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                            <label class="fs-5 col-md-2">Country </label>
                            <input type="text" class="form-control-lg border-0 col-md-10" required="required"
                                   name="country" placeholder="enter the country made "
                                   value="<?php echo $item['country_made'] ?>">
                        </div>

                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                            <label class="fs-5 col-md-2">Status </label>
                            <select name="status" class="position-relative">
                                <option value="0"> .....</option>
                                <option value="1" <?php if ($item['status'] == 1) {
                                    echo 'selected';
                                } ?>> New
                                </option>
                                <option value="2" <?php if ($item['status'] == 2) {
                                    echo 'selected';
                                } ?>> Old
                                </option>
                                <option value="3" <?php if ($item['status'] == 3) {
                                    echo 'selected';
                                } ?>> Like New
                                </option>
                                <option value="4" <?php if ($item['status'] == 4) {
                                    echo 'selected';
                                } ?>> Some Scratch
                                </option>

                            </select>
                        </div>
                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                            <label class="fs-5 col-md-2">Member </label>
                            <select name="member" class="position-relative">
                                <option value="0"> .....</option>
                                <?php
                                $stmt = $con->prepare("SELECT * FROM users ");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user) {
                                    echo " <option  value='" . $user['user_id'] . "' ";
                                    if ($user['user_id'] == $item['member_id']) {
                                        echo 'selected';
                                    }

                                    echo "  >" . $user['user_name'] . "</option> ";
                                }

                                ?>

                            </select>
                        </div>

                        <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                            <label class="fs-5 col-md-2">Category </label>
                            <select name="category" class="position-relative">
                                <option value="0"> .....</option>
                                <?php
                                $stmt = $con->prepare("SELECT * FROM categories ");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();
                                foreach ($cats as $cat) {
                                    echo " <option  value='" . $cat['id'] . "' ";
                                    if ($cat['id'] == $item['cat_id']) {
                                        echo 'selected';
                                    }

                                    echo "  >" . $cat['name'] . "</option> ";
                                }

                                ?>

                            </select>
                        </div>


                        <input type="submit" name="submitBtn" class="btn btn-primary col-md-2  mt-3 "
                               value="Save">
                    </form>
                    <!--  start the content  of comments that belongs to this item    -->
                </div>

                <?php
                // fetch data from data base
                $stmt = $con->prepare("SELECT 
                                               comments.* , users.user_name 
                                       FROM 
                                               comments 
                                       INNER JOIN 
                                               users 
                                       ON
                                               comments.user_id = users.user_id
                                      
                                        where comments.item_id =$itemId    ");
                $stmt->execute();
                $rows = $stmt->fetchAll();

                ?>
                <?php
                if (!empty($rows)) {
                    ?>
                    <div class="container">
                        <h1 class="title text-center my-4"> Manage [<?php echo $item ['item_name'] ?> ] Comments</h1>


                        <div class="table-responsive table-bordered">

                            <table class="table text-center main-table">
                                <tr>
                                    <th>Comment</th>
                                    <th> User Name</th>
                                    <th> Added Date</th>
                                    <th> control</th>
                                </tr>
                                <tbody>
                                <?php
                                foreach ($rows as $row) {
                                    ?>

                                    <tr>
                                        <td><?php echo $row['comment'] ?></td>
                                        <td><?php echo $row['user_name'] ?></td>
                                        <td><?php echo $row['c_date'] ?></td>

                                        <td>
                                            <button class="btn btn-success btn-sm "><a
                                                        class="text-decoration-none text-light"
                                                        href="Comments.php?do=edit&comment_id=<?php echo $row['c_id'] ?>">
                                                    <i class="fa fa-edit fa-fw"> </i> Edit</a></button>
                                            <button class="btn btn-danger btn-sm"><a
                                                        class="text-decoration-none text-light confirm"
                                                        href="Comments.php?do=delete&comment_id=<?php echo $row['c_id'] ?>"><i
                                                            class="fa-solid fa-trash fa-fw"></i> Delete </a></button>
                                            <?php
                                            if ($row['status'] == 0) {
                                                $id = $row["c_id"];
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
                }
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

        echo '<h1 class="text-center my-4 fw-bold"> Update Item  </h1>';
        echo '<div class="container"> ';
        if (isset($_POST['submitBtn'])) {

            $id = $_POST['input_id'];
            $item_name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $cat = $_POST['category'];

            $errors = [];
            if (empty($item_name)) {
                $errors[] = "name should be not  <strong> empty </strong>";
            }
            if (empty($desc)) {
                $errors[] = "description  should be not  <strong> empty </strong>";
            }
            if (empty($price)) {
                $errors[] = "price should be not  <strong> empty </strong>";
            }
            if (empty($country)) {
                $errors[] = "country name should be not <strong> empty </strong>";
            }
            if (empty($status)) {
                $errors[] = "you should choose an  <strong> status</strong> for  item before add    ";
            }
            if (empty($cat)) {
                $errors[] = "you should choose an  <strong> category</strong> for  item before add    ";
            }
            if (empty($member)) {
                $errors[] = "you should choose an  <strong> member</strong> for  item before add    ";
            }
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger "> ' . $error . '</div> ';
            }

            if (empty($errors)) {


                $stmt = $con->prepare("UPDATE items
                SET item_name=? ,description=? ,price =?  ,country_made =? ,status=?  ,cat_id = ? ,  member_id =? where item_id = ?");
                $stmt->execute(
                    array(

                        $item_name,
                        $desc,
                        $price,
                        $country,
                        $status,
                        $cat,
                        $member,
                        $id
                    )
                );
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $theMsg = " <div class='alert alert-success'>$count record inserted  </div>";

                    redirct($theMsg, 'back');
                } else {
                    $theMsg = " <div class='alert alert-success'>you will be redirected to manage page   </div>";
                    redirct($theMsg, 'back', 5);
                }
            }


        } else {
            $theMsg = ' <div class="alert alert-danger">you can\'t access this page </div>  ';
            redirct($theMsg);

        }
        echo '</div> ';

    }
    // ---------- ............. end of update page ......... --------- \\


    // ---------- ............. start of add page ......... --------- \\
    elseif ($do == "add") {
        ?>
        <h1 class="edit text-center my-3">Add Item </h1>
        <div class="container d-flex justify-content-center align-items-center ">
            <form class="col-sm-10 col-md-7 h-50 p-3 shadow-lg rounded-2  position-relative " method="POST"
                  action="?do=insert">
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                    <label class="fs-5 col-md-2">Name </label>
                    <input type="text" class="form-control-lg border-0 col-md-10"
                           name="name" placeholder="enter the name of Item ">
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative">
                    <label class="fs-5 col-md-2">Description </label>
                    <input type="text" class="form-control-lg border-0 col-md-10"
                           name="description" placeholder="enter the Description ">
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                    <label class="fs-5 col-md-2">Price </label>
                    <input type="text" class="form-control-lg border-0 col-md-10"
                           name="price" placeholder="enter the Price of Item ">
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                    <label class="fs-5 col-md-2">Country </label>
                    <input type="text" class="form-control-lg border-0 col-md-10" required="required"
                           name="country" placeholder="enter the country made ">
                </div>

                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                    <label class="fs-5 col-md-2">Status </label>
                    <select name="status" class="position-relative">
                        <option value="0"> .....</option>
                        <option value="1"> New</option>
                        <option value="2"> Old</option>
                        <option value="3"> Like New</option>
                        <option value="4"> Some Scratch</option>

                    </select>
                </div>
                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                    <label class="fs-5 col-md-2">Member </label>
                    <select name="member" class="position-relative">
                        <option value="0"> .....</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM users ");
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                        foreach ($users as $user) {
                            echo " <option  value='" . $user['user_id'] . "'>" . $user['user_name'] . "</option> ";
                        }

                        ?>

                    </select>
                </div>

                <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center ">
                    <label class="fs-5 col-md-2">Category </label>
                    <select name="category" class="position-relative">
                        <option value="0"> .....</option>
                        <?php
                        $stmt = $con->prepare("SELECT * FROM categories ");
                        $stmt->execute();
                        $cats = $stmt->fetchAll();
                        foreach ($cats as $cat) {
                            echo " <option  value='" . $cat['id'] . "'>" . $cat['name'] . "</option> ";
                        }

                        ?>

                    </select>
                </div>


                <input type="submit" name="submitBtn" class="btn btn-primary col-md-2  mt-3 "
                       value="Add">
            </form>
        </div>

        <?php

    }
    // ---------- ............. end of add page ......... --------- \\


    // ---------- ............. start of insert page ......... --------- \\

    elseif ($do == "insert") {
        echo '<h1 class="text-center my-4 fw-bold"> Insert Member  </h1>';
        echo '<div class="container"> ';

        if (isset($_POST['submitBtn'])) {


            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $cat = $_POST['category'];

            $errors = [];
            if (empty($name)) {
                $errors[] = "name should be not  <strong> empty </strong>";
            }
            if (empty($desc)) {
                $errors[] = "description  should be not  <strong> empty </strong>";
            }
            if (empty($price)) {
                $errors[] = "price should be not  <strong> empty </strong>";
            }
            if (empty($country)) {
                $errors[] = "country name should be not <strong> empty </strong>";
            }
            if (empty($status)) {
                $errors[] = "you should choose an  <strong> status</strong> for  item before add    ";
            }
            if (empty($cat)) {
                $errors[] = "you should choose an  <strong> category</strong> for  item before add    ";
            }
            if (empty($member)) {
                $errors[] = "you should choose an  <strong> member</strong> for  item before add    ";
            }
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger "> ' . $error . '</div> ';
            }

            if (empty($errors)) {


                $stmt = $con->prepare("INSERT INTO 
                                            items(item_name,description,price ,country_made,status ,cat_id,  member_id, add_date ) 
                                                VALUES
                                                    (:zname,:zdesc,:zprice,:zcountry, :zstatus , :zcat,:zmember, now()) ");
                $stmt->execute(
                    array(

                        'zname' => $name,
                        'zdesc' => $desc,
                        'zprice' => $price,
                        'zcountry' => $country,
                        'zstatus' => $status,
                        'zcat' => $cat,
                        'zmember' => $member
                    )
                );
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $theMsg = " <div class='alert alert-success'>$count record inserted  </div>";

                    redirct($theMsg, 'back');
                }
            } else {
                $theMsg = " <div class='alert alert-success'>you will be redirected to manage page   </div>";
                redirct($theMsg, 'back', 100);
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
        if (isset($_GET['item_id']) && is_numeric(intval($_GET['item_id']))) {
            // check found in database or no
            $check = checkItemFound('item_id', 'items', $_GET['item_id']);

            if ($check > 0) {
                $stmt = $con->prepare("DELETE FROM items WHERE item_id = :zitem_id limit 1");
                $stmt->bindParam(':zitem_id', $_GET['item_id']);
                $stmt->execute();
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

// ---------- ............. start of activate page ......... --------- \\
    elseif ($do == 'approve') {
        echo '<div class="container " >';
        if (isset($_GET['item_id']) && is_numeric(intval($_GET['item_id']))) {
            // check found in database or no
            $id = $_GET['item_id'];
            $check = checkItemFound('item_id', 'items', $id);

            if ($check > 0) {
                $stmt = $con->prepare("UPDATE items SET approve=1 WHERE item_id= ?");

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

// ---------- ............. end of activate page ......... --------- \\

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