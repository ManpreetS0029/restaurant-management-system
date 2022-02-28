<?php

$sql = $conn->prepare("select * from user_table where user_id = '".$_SESSION['user_id']."'");
$sql->execute();
$row = $sql->fetchAll();
?>
<nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>

            <li>
              <!--
                <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
-->
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
           <?php foreach($row as $user)
           {

            if($user["user_profile"] != "")
            {
              $user_profile = "admin/uploads/dp/".$user["user_profile"];

            }

            else
            {
              $user_profile = "assets/img/user.png";
            }
             ?>
             <li class="dropdown"><a href="#" data-toggle="dropdown"
               class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php  echo $user_profile; ?>" class="user-img-radious-style"
                 >  <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello <?php echo $userType; ?></div>
              <a href="user-profile.php" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="logout.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
          <?php


        } ?>
        </ul>
      </nav>
