<?php
session_start();

if (isset($_SESSION['username'])) {
    header('Location:dashboard.php');
}

$noNavbar  = '';
$pageTitle = 'login';
include "init.php";


if (isset($_POST['submitBtn'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedPass = sha1($password);
global $con;
    $stmt = $con->prepare("SELECT 
                               user_id, user_name ,password
                           FROM 
                                users 
                            WHERE 
                                user_name=? 
                            AND 
                                password=?
                            AND 
                                 group_id=1
                            lIMIT 1 
                            ");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $row['user_id'];
        header('Location:dashboard.php');
        exit();
    }
}

?>



<form class="login myform" method="post">
    <h3 class="text-center mb-3 fs-4"> admin Login</h3>
        <input class="form-control mb-2" type="text" name="user" placeholder="user name :" autocomplete="off" />
        <input class="form-control mb-2" type="password" name="pass" placeholder="password :" autocomplete="off"/>
    <button class="btn btn-primary w-100 p-1  " type="submit" name="submitBtn"> Login </button>
</form>



<?php global  $tpl; include $tpl . "footer.php"; ?>