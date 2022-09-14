<?php
session_start();
global $tpl;
global $con;
global $userSession;
$pageTitle = 'Profile';
include "init.php";


if (isset($_SESSION['user'])) {
    $getuser = $con->prepare("SELECT * 
            FROM 
                users
            WHERE 
                user_name = ? 
    ");
    $getuser->execute(array($userSession));
    $userData = $getuser->fetch();
}

?>
<div class="container">
    <div class="card mt-4  information">
        <div class="card-header bg-primary text-light">
            My Information
        </div>
        <div class="card-body border-1 border-primary border user-information">
            <ul class="list-unstyled">
                <li>
                    <i class="fa-solid fa-unlock fa-fw"></i>
                    <span>Name : <?php echo $userData['user_name'] . '<br/> ' ?></span>
                </li>
                <li>
                    <i class="fa-solid fa-user  fa-fw"></i>
                    <span>Full Name : <?php echo $userData['full_name'] . '<br/> ' ?></span>
                </li>
                <li>
                    <i class="fa-solid fa-envelope fa-fw"></i>
                    <span>Email : <?php echo $userData['email'] . '<br/> ' ?></span>
                </li>
                <li>
                    <i class="fa-solid fa-calendar fa-fw"></i>
                    <span>Register Date : <?php echo $userData['date'] . '<br/> ' ?></span>
                </li>
                <li>
                    <i class="fa-solid fa-tag fa-fw"></i>
                    <span>Favorite Category :</span>
                </li>
            </ul>

        </div>
    </div>

    <div class="card mt-4  ads">
        <div class="card-header bg-primary text-light">
            Ads
        </div>
        <div class="card-body border-1 border-primary border">

            <?php // get user ads
            $memberItems = getItems('member_id', $userData['user_id']);
            if (!empty($memberItems)) {
                echo '<div class="row">';
                foreach ($memberItems as $memberItem) {

                    echo '<div class="col-sm-6 col-md-3"> ';
                    echo  '<div class="item-data"> ';
                    echo '<span class="item-price">' . $memberItem['price'] . '</span>';
                    echo '<img class="img-fluid"  src="avataaars.png" alt="not found image " >';
                    echo '<h3>' . $memberItem['item_name'] . '</h3>';
                    echo '<p> ' . $memberItem['description'] . '</p>';
                    echo '</div> ';
                    echo '</div> ';
                }
                echo ' </div>';
            } else {
                echo 'there\'s no ads to show  <a href="newAd.php" class="text-primary " >  New Ad </a>' ;
            }


            ?>

        </div>
    </div>


    <div class="card mt-4  comments">
        <div class="card-header bg-primary text-light">
            My Comments
        </div>
        <div class="card-body border-1 border-primary border">
            <?php
            $stmt = $con->prepare("SELECT comment FROM comments WHERE  user_id = ? ");
            $stmt->execute(array($userData['user_id']));
            $comments = $stmt->fetchAll();
            if (!empty($comments)) {
                foreach ($comments as $comment) {
                    echo '<p>' . $comment['comment'] . '</p>';
                }
            } else {
                echo 'there\'s no comments to show ';
            }
            ?>
        </div>
    </div>

</div>


<?php
include $tpl . "footer.php";
?>