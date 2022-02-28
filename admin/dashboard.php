<?php
session_start();
require_once "appcode/db_connection.php";

$countCategory = $conn->prepare("select count(*) from product_category_table");
$countCategory->execute();
$totalCategory = $countCategory->fetchColumn();

$countTable = $conn->prepare("select count(*) from table_data");
$countTable->execute();
$totalTable = $countTable->fetchColumn();

$countTax = $conn->prepare("select count(*) from tax_table");
$countTax->execute();
$totalTax = $countTax->fetchColumn();

$countProduct = $conn->prepare("select count(*) from product_table");
$countProduct->execute();
$totalProduct = $countProduct->fetchColumn();

$countUser = $conn->prepare("select count(*) from user_table");
$countUser->execute();
$totalUser = $countUser->fetchColumn();

$getTables = $conn->prepare("select * from table_data");
$getTables->execute();
$fetchTables = $getTables->fetchAll();

$getOrderTable = $conn->prepare("select * from order_table");
$getOrderTable->execute();
$fetchOrderTable = $getOrderTable->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css-new/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css-new/style.css">
  <link rel="stylesheet" href="assets/css-new/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css-new/custom.css">
  <link rel="stylesheet" href="assets/css/style.css?ver=<?php echo rand(1,1000); ?>">
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
                class="logo-name">Admin</span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">

        <h1> Admin Dashboard </h1>

        <div class="mt-4">
          <div class="row">
            <div class="col-md-2">
              <a href="category.php">
              <div class="cat">
                <div>Total Category</div>
                <div class="mt-2">
                  <?php echo $totalCategory; ?>
                </div>
              </div>
            </a>
            </div>

            <div class="col-md-2 dash-grid">
            <a href="table.php">
              <div class="tbl">
                <div>Total Table</div>
                <div class="mt-2">
                  <?php echo $totalTable; ?>
                </div>
              </div>
            </div>

            <div class="col-md-2 dash-grid">
              <a href="tax.php">
              <div class="tax">
                <div>Total Tax</div>
                <div class="mt-2">
                  <?php echo $totalTax; ?>
                </div>
              </div>
            </a>
            </div>

            <div class="col-md-2 dash-grid">
              <a href="product.php">
              <div class="product">
                <div>Total Product</div>
                <div class="mt-2">
                  <?php echo $totalProduct; ?>
                </div>
              </div>
            </a>
            </div>

            <div class="col-md-2 dash-grid">
              <a href="user.php">
              <div class="user">
                <div>Total Users</div>
                <div class="mt-2">
                  <?php echo $totalUser; ?>
                </div>
              </div>
            </a>
            </div>

            </div>

         <div class="bg-dash mt-3">
            <div class="row">

                <div class="col">

                <h3 class="ml-3 ">Live Table Status</h3>
                <hr>


                <div class="row p-2">

                <?php

                    foreach($fetchTables as $table)
                    {

                      $getOrderTable = $conn->prepare("select * from order_table where order_table = ? and order_status = ?");
                      $getOrderTable->execute(array($table["table_name"],"In Process"));
                      $fetchOrderTable = $getOrderTable->fetch(PDO::FETCH_ASSOC);

                ?>
                       <div class="col-md-2 ml-4 mt-2 p-4 rounded tbl-grid-dash">

                       <div>
                            <?php


                            echo $table["table_name"];

                            ?>
                           </div>
                           <div>
                           <?php
                           echo $table["table_capacity"]." Persons";
                           ?>
                    </div>
                    <div>
                    <?php

                    if($fetchOrderTable["order_table"] == $table["table_name"])
                      {
                        echo "<span style='color: #FFFF00;'><b>Occupied</b></span>";
                      }
                    ?>
                    </div>
                  
                       </div>



                <?php  } ?>

                </div>

                </div>

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
