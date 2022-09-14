<?php
ob_start();
session_start();
if (isset($_SESSION['user']) && $_SESSION['user']) {
    header("Location:index.php");
}
global $tpl;
global $con;
$pageTitle = 'Log in ';
include "init.php";
$formErrors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['loginBtn'])) {
        $name = $_POST['login-name'];
        $pass = $_POST['login-pass'];
        $hashed_pass = sha1($pass);

        $stmt = $con->prepare("SELECT 
            user_id , user_name , password 
            FROM 
                users
            WHERE 
                user_name = ? 
            AND 
                password = ? 
         ");
        $stmt->execute(array($name, $pass));
        $getdataofuser = $stmt->fetch() ; 
        $count = $stmt->rowCount();
        if ($count > 0) {
            $_SESSION['user'] = $name;
            $_SESSION['uid'] = $getdataofuser['user_id'];
            header("Location:index.php");
            exit();
        }
    } else {


        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];

        $hashed_pass1 = sha1($pass);
        $hashed_pass2 = sha1($pass2);
        //validate name of user 
        if (isset($_POST['name'])) {
            if (empty($name)) {
                $formErrors[] = "Name must be not empty ";
            }
            if (strlen($name) < 4) {
                $formErrors[] = "Name must be larger  than 4 ";
            }
        }
        //validate email 
        if (isset($_POST['email'])) {
            $filterdEmail = filter_var($email , FILTER_SANITIZE_EMAIL) ; 
            if( filter_var($filterdEmail , FILTER_VALIDATE_EMAIL) != true ) {
                $formErrors[] = "sorry you have an error at your email" ; 
            }
            if (empty($filterdEmail) || empty($email) ){
                $formErrors[] = "sorry email cant be empty " ; 
            }
            if (strlen($filterdEmail) < 4 ) {
                $formErrors[] = "sorry email cant less than four characters  ";
            }
        }


        // validate password 
        if (isset($_POST['pass']) && $_POST['pass2']) {
             if(empty($_POST['pass']) ){
                $formErrors[] = "sorry pass cant be empty" ; 
             }

            if ($hashed_pass1 !== $hashed_pass2) {
                $formErrors[] = "Sorry password not identical ";
            }
        }


        if (empty($formErrors)) {
            $check = checkItemFound("user_name", "users", $name);
            
            
            if ($check == 1) {
                $formErrors[] = "sorry this user is exists " ; 
            } else {
                $stmt = $con->prepare("INSERT INTO 
                                            users(user_name,password ,email, date ,reg_status) 
                                                VALUES
                                                    (:zuser,:zpass ,:zeamil , now() , 0) ");
                $stmt->execute(
                    array(

                        'zuser' => $name,
                        'zpass' =>$hashed_pass1,
                        'zeamil' => $email
                    )
                );
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $successMsg ="you are registerd successfully " ; 
                }
            }
        }



    }




}

?>



<div class="main">
    <div class="spetial-container">
        <input type="checkbox" id="chk">

        <div class="login">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <h3 class="text-center d-flex justify-content-center align-items-center p-2 mb-3"><label for="chk"> Login </label></h3>
                <label for="name">Name </label>
                <input class="form-control" type="text" id="name" name="login-name">
                <label for="pass"> Password </label>
                <input class="form-control" type="password" name="login-pass">
                <div class="centerBtn text-center">
                    <button type="submit" name="loginBtn"> Login </button>
                </div>
                <div class="icons text-center  ">
                    <img src="layout/images/fb.png" alt="">
                    <img src="layout/images/gp.png" alt="">
                    <img src="layout/images/tw.png" alt="">
                </div>
            </form>
        </div>
        <div class="signup">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <h3 class="text-center d-flex justify-content-center align-items-center p-2 "><label for="chk"> Sign up </label></h3>
                <label for="name">Username </label>
                <input
                pattern=".{3 , }"
                title="username should be large than 4 characters "
                    class="form-control" 
                    type="text" 
                    id="name" 
                    name="name"
                    required 
                    >
                <label for="email">Email</label>
                <input 

                    class="form-control" 
                    type="email" 
                    id="email"
                    name="email" 
                    required>
                <label for="pass"> Password </label>
                <input 
                minlength = "4"
                    class="form-control"
                    type="password"
                    name="pass" 
                    required>
                <label for="pass"> Repeat Password </label>
                <input 
                    class="form-control"
                    type="password"
                    name="pass2">
                <div class="centerBtn text-center">
                    <button type="submit"> Sign Up </button>
                </div>
                <div class="text-center"><label for="chk"> already have an account ! </label></div>
                <div class="icons text-center  ">
                    <img src="layout/images/fb.png" alt="">
                    <img src="layout/images/gp.png" alt="">
                    <img src="layout/images/tw.png" alt="">
                </div>
            </form>
        </div>


    </div>

    <?php
    foreach ($formErrors as $formError) {
        echo $formError . "<br/>";
    } 
    
    if(isset($successMsg)){
        echo $successMsg  ; 
    }
    
    ?>ح


</div>


<?php include $tpl . "footer.php";
ob_end_flush();
?>