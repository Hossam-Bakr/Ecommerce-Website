<?php
session_start();
global $tpl;
global $con;
global $userSession;
$pageTitle = 'Profile';
include "init.php";
global $formErrors ; 

if ($_SERVER['REQUEST_METHOD'] =='POST' &&isset($_POST['submitBtn'])) {
  $formErrors =array() ; 
  $name = $_POST['name']; 
  $desc = $_POST['description'];
  $price = filter_var($_POST['price'] ,FILTER_SANITIZE_NUMBER_INT);
  $country = $_POST['country'];
  $status = $_POST['status'];
  $category = filter_var($_POST['category'] ,FILTER_SANITIZE_NUMBER_INT);
    if (empty($name)) {
      $formErrors[] = "sorry name cant be empty  " ; 
    }
    if (empty($desc)) {
      $formErrors[] = "sorry desc cant be empty  " ; 
    }
    if (empty($price)) {
      $formErrors[] = "sorry price cant be empty  " ; 
    }
    if (empty($category)) {
      $formErrors[] = "sorry category cant be empty  " ; 
    }
    if (empty($country)) {
      $formErrors[] = "sorry country cant be empty  " ; 
    }
    if (empty($status)) {
      $formErrors[] = "sorry status cant be empty  " ; 
    }

    if(strlen($name) < 3 ) {
        $formErrors[] = "sorry name should be large than 2 characters   "; 
    }

    if(strlen($desc) < 10) {
        $formErrors[] = "sorry desc should be large than 10 characters   "; 
    }

    if(strlen($price) < 1 ) {
        $formErrors[] = "sorry price should be large than 1   "; 
    }


    if (empty($formErrors)) {


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
          'zcat' => $category,
          'zmember' => $_SESSION['uid']
        )
      );
      if ($stmt) {
         echo "addded" ; 
      }
    } else {
      echo " <div class='alert alert-danger'>  you have an error in data edit it and try again  of ad </div>";
    }


}



if (isset($_SESSION['user'])) {
?>
  <div class="container">
    <h1 class="text-center mt-3"> New Ad </h1>
    <div class="card mt-4  ads ">
      <div class="card-header bg-primary text-light">
        NEW AD
      </div>
      <div class="card-body border-1 border-primary border user-information mb-3">
        <div class="row">
          <div class="col-md-9">



       <form class=" p-3 shadow-lg rounded-2  position-relative h-100 " method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">
              <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                <label class="fs-5 col-md-2">Name </label>
                <input type="text" class="form-control-lg  border border-info col-md-10 live" data-class=".live-title" name="name" placeholder="enter the name of Item ">
              </div>
              <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative">
                <label class="fs-5 col-md-2">Description </label>
                <input type="text" class="form-control-lg border border-info  col-md-10 live" data-class=".live-desc" name="description" placeholder="enter the Description ">
              </div>
              <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                <label class="fs-5 col-md-2">Price </label>
                <input type="text" class="form-control-lg border border-info  col-md-10 live" data-class=".live-price" name="price" placeholder="enter the Price of Item ">
              </div>



              <div class="input-container mb-2  w-100 d-flex justify-content-center align-items-center position-relative ">
                <label class="fs-5 col-md-2">Country </label>
                <input type="text" class="form-control-lg border border-info  col-md-10 live" data-class="." required="required" name="country" placeholder="enter the country made ">
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


              <input type="submit" name="submitBtn" class="btn btn-primary col-md-2  mt-3 " value="Add">
            </form>
          </div>
          <div class="col-md-3 ">
            <div class="col-sm-12">
              <div class="item-data">
                <span class="item-price "> $ <span class="live-price"></span></span>
                <img class="img-fluid" src="avataaars.png" alt="not found image ">
                <h3 class="live-title"> title </h3>
                <p class="live-desc"> description </p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>


<?php 
echo '<div>  ' ; 
if (!empty($formErrors) && isset($formErrors)) {
    foreach ($formErrors as  $formError) {
      echo '<div class="alert alert-danger">' . $formError . '</div> ';
    }
}
echo '</div>'; 

?>


  </div>

<?php } ?>


<?php
include $tpl . "footer.php";
?>