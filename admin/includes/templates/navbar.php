

 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
     <div class="container">

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav me-auto mb-2 mb-lg-0 w-100">
                 <li class="nav-item">
                     <a class="nav-link" href="dashboard.php"><?php echo lang("admin_home") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="Categories.php"><?php echo lang("categories") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="member.php"><?php echo lang("members") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="Items.php"><?php echo lang("items") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="Comments.php"><?php echo lang("comments") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="#"><?php echo lang("statistics") ?> </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="#"><?php echo lang("logs") ?> </a>
                 </li>

                 <li class="nav-item dropdown ms-auto">
                     <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Hossam
                     </a>
                     <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                         <li><a class="dropdown-item" href="../index.php">Visit Website </a></li>

                         <li><a class="dropdown-item" href="#"><?php echo lang("settings") ?></a></li>
                         <li><a class="dropdown-item" href="member.php?do=edit&user_id=<?php echo $_SESSION['id']?>"><?php echo lang("edit") ?></a></li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         <li><a class="dropdown-item" href="logout.php"><?php echo lang("logout") ?></a></li>
                     </ul>
                 </li>

             </ul>

         </div>
     </div>
 </nav>