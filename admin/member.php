<?php

/* 
 ==========================================
 ==== edit members 
 ==== add |remove |update members 
 ==========================================

 */
session_start();
$pageTitle = 'Members page';
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
        $query = '';
        if (isset($_GET['page']) && $_GET['page'] == 'pending') {
            $query = 'AND reg_status=0';
        }
        $stmt = $con->prepare("SELECT * FROM users Where group_id=0 $query");
        $stmt->execute();
        $members = $stmt->fetchAll();
        if (!empty($members)) {
            ?>
            <h1 class="title text-center my-4"> Manage Members page </h1>

            <div class="container">
            <div class="table-responsive table-bordered">
                <table class="table text-center main-table">
                    <tr>
                        <th>id</th>
                        <th>User name</th>
                        <th>Email</th>
                        <th> Full name</th>
                        <th> Registerd Date</th>
                        <th> control</th>
                    </tr>
                    <tbody>
                    <?php
                    foreach ($members as $member) {
                        ?>

                        <tr>
                            <td><?php echo $member['user_id'] ?></td>
                            <td><?php echo $member['user_name'] ?></td>
                            <td><?php echo $member['email'] ?></td>
                            <td><?php echo $member['full_name'] ?></td>
                            <td><?php echo $member['date'] ?></td>

                            <td>
                                <button class="btn btn-success "><a class="text-decoration-none text-light"
                                                                    href="?do=edit&user_id=<?php echo $member['user_id'] ?>">
                                        <i class="fa fa-edit fa-fw"> </i> Edit</a></button>
                                <button class="btn btn-danger"><a class="text-decoration-none text-light confirm"
                                                                  href="?do=delete&user_id=<?php echo $member['user_id'] ?>"><i
                                                class="fa-solid fa-trash fa-fw"></i> Delete </a></button>
                                <?php
                                if ($member['reg_status'] == 0) {
                                    $id = $member["user_id"];
                                    echo " <button class='btn btn-info'><a class='text-decoration-none text-light' href='?do=activate&user_id=$id' <i class='fa-solid fa-circle-check fa-fw'></i> Activate </a></button> ";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>


                </table>
            </div>
            <?php
            } else {
                echo '<div class="container mt-3 " > ';
                echo '<div class="nice-message " >  there is no such items   </div>';
                echo ' </div>';
//                this container for contain the button when no members found
                echo '<div class="container mt-3 " > ';
            }

        ?>

        <button class="btn btn-primary "><a href="?do=add" class=" text-light text-decoration-none"> <i
                        class="fa-solid fa-circle-plus fa-fw"></i> new member </a></button>

        </div>


    <?php }
    // ---------- ............. end of manage page ......... --------- \\


    // ---------- ............. start of edit page ......... --------- \\

    else if ($do == 'edit') {
        if (isset($_GET['user_id']) && is_numeric(intval($_GET['user_id']))) {

            $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ? limit 1  ");
            $stmt->execute(array($_GET['user_id']));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count > 0) {

                ?>

                <h1 class="edit text-center my-5">Edit Member </h1>

                <div class="container d-flex justify-content-center align-items-center">
                    <form class="col-sm-10 col-md-7 h-50 p-3 border border-1 border-dark rounded-2  " method="POST"
                          action="?do=update">
                        <label class="fs-4">User Name </label>
                        <input type="text" class="form-control my-2" required='required' autocomplete="off"
                               name="username" value="<?php echo $row['user_name'] ?>">
                        <input type="hidden" name="input_id" value="<?php echo $row['user_id'] ?>">

                        <label class="fs-4">Email </label>
                        <input type="email" class="form-control my-2" autocomplete="off" required='required'
                               name="email" value="<?php echo $row['email'] ?> ">

                        <label class=" fs-4">Password </label>
                        <input type="hidden" name="old_password" value="<?php echo $row['password'] ?> ">
                        <input type="password" class="form-control my-2" name="new_password">

                        <label class=" fs-4">Full Name </label>
                        <input type="text" class="form-control my-2" autocomplete="off" required='required'
                               name="full_name" value="<?php echo $row['full_name'] ?> ">

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


    // ---------- ............. start of add page ......... --------- \\
    elseif ($do == "add") { ?>
        <h1 class="edit text-center my-3">Add Member page </h1>

        <div class="container d-flex justify-content-center align-items-center">
            <form class="col-sm-10 col-md-7 h-50 p-3 shadow-lg rounded-2  " method="POST"
                  action="?do=insert">
                <div class="input-container w-100 position-relative">
                    <label class="fs-4">User Name </label>
                    <input type="text" class="form-control-lg border-0 my-2 w-100" autocomplete="off"
                           required='required' name="username" placeholder="user name to login into shop">

                </div>
                <div class="input-container w-100 position-relative">
                    <label class="fs-4">Email </label>
                    <input type="email" class="form-control-lg border-0 w-100 my-2" required='required' name="email"
                           autocomplete="off" placeholder="email should be valid ">
                </div>
                <div class="input-container w-100 position-relative  ">

                    <label class=" fs-4 ">Password </label>
                    <div class="d-flex">
                        <input type="password" class="form-control-lg border-0 w-100 my-2 password" name="password"
                               autocomplete="off" required placeholder="enter a complex password ">
                        <i class="fa fa-eye fa-2x show_pass position-absolute  top-50 eye "></i>
                    </div>

                </div>
                <div class="input-container w-100 position-relative">

                    <label class=" fs-4">Full Name </label>
                    <input type="text" class="form-control-lg border-0 w-100 my-2" required='required'
                           name="full_name" autocomplete="off" placeholder="full name will appear in profile ">
                </div>

                <input id="subBtn" type="submit" class="btn btn-primary my-2" name="submitBtn"
                       value="add new member ">
            </form>
        </div>
    <?php } // ---------- ............. end of add page ......... --------- \\


    // ---------- ............. start of insert page ......... --------- \\

    elseif ($do == "insert") {
        echo '<h1 class="text-center my-4 fw-bold"> Insert Member  </h1>';
        echo '<div class="container"> ';

        if (isset($_POST['submitBtn'])) {


            $username = $_POST['username'];
            $email = $_POST['email'];
            $full_name = $_POST['full_name'];
            $pass = $_POST['password'];

            $hashpass = sha1($_POST['password']);

            $errors = [];
            if (empty($username)) {
                $errors[] = "user name should be not  <strong> empty </strong>";
            }
            if (empty($email)) {
                $errors[] = "email  should be not  <strong> empty </strong>";
            }
            if (empty($pass)) {
                $errors[] = "password should be not  <strong> empty </strong>";
            }
            if (empty($full_name)) {
                $errors[] = "full name should be not <strong> empty </strong>";
            }
            if (strlen($username) < 4) {
                $errors[] = "user name should be <strong> more than 4 </strong> characters ";
            }
            if (strlen($username) > 12) {
                $errors[] = "user name should be<strong> less than 12 </strong> characters ";
            }
            if (strlen($full_name) < 6) {
                $errors[] = "full name should be <strong> more than 6 characters </strong> ";
            }
            if (strlen($full_name) > 18) {
                $errors[] = "full name should be  <strong> less than 18 characters  </strong> ";
            }

            foreach ($errors as $error) {
                echo '<div class="alert alert-danger "> ' . $error . '</div> ';
            }

            if (empty($errors)) {
                $check = checkItemFound("user_name", "users", $username);
                if ($check == 1) {
                    $theMsg = " <div class='alert alert-danger' > sorry this username is found  </div>";

                    redirct($theMsg, 'back');

                } else {


                    $stmt = $con->prepare("INSERT INTO 
                                            users(user_name,password,full_name,email, date ,reg_status) 
                                                VALUES
                                                    (:zuser,:zpass,:zfullname,:zeamil , now() , 1) ");
                    $stmt->execute(
                        array(

                            'zuser' => $username,
                            'zpass' => $hashpass,
                            'zfullname' => $full_name,
                            'zeamil' => $email
                        )
                    );
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        $theMsg = " <div class='alert alert-success'>$count record inserted  </div>";

                        redirct($theMsg, 'back');
                    }
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
        if (isset($_GET['user_id']) && is_numeric(intval($_GET['user_id']))) {
            // check found in database or no
            $check = checkItemFound('user_id', 'users', $_GET['user_id']);


            if ($check > 0) {
                $stmt = $con->prepare("DELETE FROM users WHERE user_id = :zuser_id limit 1");
                $stmt->bindParam(':zuser_id', $_GET['user_id']);
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


    // ---------- ............. start of update page ......... --------- \\

    elseif ($do == 'update') {

        echo '<h1 class="text-center my-4 fw-bold"> Update Member  </h1>';
        echo '<div class="container"> ';
        if (isset($_POST['submitBtn'])) {


            $user_id = $_POST['input_id'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $full_name = $_POST['full_name'];
            $pass = '';
            if (empty($_POST['new_password'])) {
                $pass = $_POST['old_password'];
            } else {
                $pass = sha1($_POST['new_password']);
            }


            $errors = [];
            if (empty($username)) {
                $errors[] = "user name should be not  <strong> empty </strong>";
            }
            if (empty($email)) {
                $errors[] = "email name should be not  <strong> empty </strong>";
            }
            if (empty($full_name)) {
                $errors[] = "full name should be not <strong> empty </strong>";
            }
            if (strlen($username) < 4) {
                $errors[] = "user name should be <strong> more than 4 </strong> characters ";
            }
            if (strlen($username) > 12) {
                $errors[] = "user name should be<strong> less than 12 </strong> characters ";
            }
            if (strlen($full_name) < 6) {
                $errors[] = "full name should be <strong> more than 6 characters </strong> ";
            }
            if (strlen($full_name) > 18) {
                $errors[] = "full name should be  <strong> less than 18 characters  </strong> ";
            }


            foreach ($errors as $error) {
                echo '<div class="alert alert-danger "> ' . $error . '</div> ';
            }

            $stmt = $con->prepare("UPDATE users SET user_name=? , email=? ,  full_name = ? , password =? WHERE user_id=?");
            $stmt->execute(array($username, $email, $full_name, $pass, $user_id));
            $count = $stmt->rowCount();
            $theMsg = "<div class='alert alert-success' >   $count record updated   </div> ";
            redirct($theMsg, "back");


        } else {
            $theMsg = ' <div class="alert alert-danger">you cant access this page </div>  ';
            redirct($theMsg);

        }
        echo '</div> ';
    } // ---------- ............. end of update page ......... --------- \\


    elseif ($do == 'activate') {
        echo '<div class="container " >';
        if (isset($_GET['user_id']) && is_numeric(intval($_GET['user_id']))) {
            // check found in database or no
            $id = $_GET['user_id'];
            $check = checkItemFound('user_id', 'users', $id);

            if ($check > 0) {
                $stmt = $con->prepare("UPDATE users SET reg_status=1 WHERE user_id= ?");

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