<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";


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

$getTables = $conn->prepare("select * from table_data");
$getTables->execute();
$fetchTables = $getTables->fetchAll();

$getOrderTable = $conn->prepare("select * from order_table");
$getOrderTable->execute();
$fetchOrderTable = $getOrderTable->fetchAll();

?>
<?php include_once "bin/toppart4pages.php"; ?>

<body>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>



       <?php include_once "bin/topbar.php"; ?>

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="#"> <i data-feather="users"></i>  <span
                class="logo-name"><?php echo $userType; ?></span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">


        <h2>Order Area</h2>

        <div class="bg mt-4">
        <div class="row">

            <div class="col">

            <h3 class="ml-3">Table Status</h3>
            <hr>


            <div class="row p-2">

            <?php

                foreach($fetchTables as $table)
                {

                  $getOrderTable = $conn->prepare("select * from order_table where order_table = ? and order_status = ?");
                  $getOrderTable->execute(array($table["table_name"],"In Process"));
                  $fetchOrderTable = $getOrderTable->fetch(PDO::FETCH_ASSOC);

            ?>
                   <div class="col-md-2 ml-4 mt-2 p-4 rounded tbl-grid">
                   <a class="link" href="add_order.php?tbl_name=<?php echo $table["table_name"]; ?>" style="text-decoration: none;color:#ffffff;">
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
                </a>
                   </div>



            <?php  } ?>

            </div>

            </div>

        </div>



        </div>

        </div>

        </div>
</div>
        </div>
      </div>

      <footer class="main-footer">
        <div class="footer-right">

        </div>
      </footer>
    </div>
  </div>

<?php include_once "bin/bottompart4pages.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>


</body>
</html>
