<?php
global $css;
global $con;
$stmt = $con->prepare("SELECT * FROM categories");
$stmt->execute();
$cats = $stmt->fetchAll();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle(); ?> </title>
    <!--============= start css links =========== -->
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>all.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $css; ?>front.css">
    <!--============= end css links =========== -->

</head>

<body>

<div class="upper-bar">
    <div class="container">
        <?php if (isset($_SESSION['user']) && $_SESSION['user'])
        {
            echo "welcome " . $_SESSION['user']  ;

            $userStatus = checkUserStatus($_SESSION['user']) ;
            if ($userStatus == 1 ) {
                echo  " <span class='mx-2 '> not active </span>  " ;
            }
            echo '<div class="fa-pull-right"> <a class="text-decoration-none ms-2" href="logout.php"> Logout </a></div>' ;
            echo '<div class="fa-pull-right"> <a class="text-decoration-none ms-2 " href="profile.php"> Profile </a></div>' ;

        }

        else {  ?>
            <span class="fa-pull-right sign-up-btn"> <a href="login.php"> Login</a> </span>
           welcome
        <?php } ?>
    </div>
</div>
<div class="clear">

</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <li class="nav-item homepage text-light" >
                <a class="nav-link" href="index.php"><?php echo lang("admin_home") ?> </a>
            </li>
            <ul class="navbar-nav ms-auto   ">


                <?php
                foreach ($cats as $cat) {
                    echo '<li class="nav-item">
                       <a class="nav-link" href="Categories.php?catid='. $cat['id'].'&pagename='.str_replace(' ', '-', $cat['name']).'">';
                        echo $cat['name'];
                    echo ' </a></li>';
                }

                ?>

            </ul>

        </div>
    </div>
</nav>