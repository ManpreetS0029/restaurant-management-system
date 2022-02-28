<?php 
session_start();
require_once "appcode/db_connection.php";

$sql = $conn->prepare("select * from user_table where user_id = '".$_SESSION['user_id']."'");
$sql->execute();
$rows = $sql->fetchAll();

foreach($rows as $row )
{
  if($row["user_type"] == "Waiter")
  {
      $userType = "Waiter";      
  }

  else
  {
        $userType = "Cashier";
  }
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $userType; ?></title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css-new/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css-new/style.css">
  <link rel="stylesheet" href="assets/css-new/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css-new/custom.css">
  <!-- <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' /> -->
</head>

<body>
  <!-- <div class="loader"></div> -->
  <?php 
  if(!$_SESSION['user_id'])
  { 

     echo "You have to login to view this file";

  }
  else
  {
      ?>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

       <?php include_once "bin/topbar.php"; ?>

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <i data-feather="users"></i>  <span
                class="logo-name"><?php echo $userType; ?></span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">

      <?php echo $_SESSION["user_id"]; ?>
         
        <h1>Dashboard </h1>

        <div class="bg mt-4">
          <div class="row">
            <div class="col">
              
            </div>
          </div>
        </div>
        
      </div>
      <!--<footer class="main-footer">
         
        <div class="footer-right">
        </div>
      </footer> -->
    </div>
  </div>

  <?php  } ?>
  <!-- General JS Scripts -->
  <script src="assets/js-new/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js-new/page/index.js"></script>
  <!-- Template JS File -->
  <script src="assets/js-new/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js-new/custom.js"></script>
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>