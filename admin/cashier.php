<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";

$_POST = array_map('trim', $_POST);
$getOrder = $conn->prepare("select * from order_item_table ");
$getOrder->execute();
$orders = $getOrder->fetchAll();
$numberOfResults = $getOrder->rowCount();

//pagination code
$numberOfPages = ceil($numberOfResults/$resultsPerPage);
$page_first_result = ($page-1)*$resultsPerPage;

if(isset($_POST["previous_page"]))
{
  $previous = $_GET["page"] - 1;

  if($_GET["page"] != "")
  {
    if($previous > 0)
    {
    header("Location: cashier.php?page=".$previous);
    }
  }
  else if($_GET["page"] == 0)
  {
    header("Location: cashier.php?page=1");
  }

}

if(isset($_POST["next_page"]))
{
  for($next = 1; $next<=$numberOfPages; $next++)
  {
    $nextPage = $next;
  }

  if($_GET["page"] != "")
  {
      header("Location: cashier.php?page=".$nextPage);
  }
  else
  {
    header("Location: cashier.php?page=2");
  }
}

$sql = $conn->prepare("select * from user_table where user_id = '".$_SESSION['user_id']."'");
$sql->execute();
$rows = $sql->fetchAll();

foreach($rows as $row )
{
  if($row["user_type"] == "Waiter")
  {
      $userType = "Waiter";      
  }

  else if($row["user_type"] == "Cashier")
  {
        $userType = "Cashier";
  }

  else
  {
    $userType = "Master";
  }
}





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
            <a href="dashboard.php"> <i data-feather="users"></i>  <span
                class="logo-name">Admin</span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>



      <!-- Main Content -->
      <div class="main-content">

        <h2>Billing Management</h2>

        <div class="bg mt-4">

        <form method="post">
        <div class="row mt-4">
         <div class="col-md-9">
           <h3>Bill List</h3>
         </div>

         <div class="input-group col-md-3">
         <input class="form-control py-2" type="search" id="example-search-input" name="keyword">
        <span class="input-group-append">
          <input class="btn btn-outline-secondary" type="submit" name="search" value="Search">
        </span>

         </div>



        </div>
      </form>

        <div class="row">

        <div class="col">



            <div class="row mt-4">

            <div class="col">

            <table class="table table-striped">

             <thead>
                 <tr>
                     <th scope="col">Table Number</th>
                     <th scope="col">Order Number</th>
                     <th scope="col">Order Date</th>
                     <th scope="col">Order Time</th>
                     <th scope="col">Waiter</th>
                     <th scope="col">Status</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>

             <tbody>

               <?php

                if(!empty($_REQUEST["keyword"]))
                {
                  $sql = $conn->prepare("select * from order_table where order_table like '%".$_REQUEST['keyword']."%' or order_number like '%".$_REQUEST['keyword']."%' or order_waiter like '%".$_REQUEST['keyword']."%' or order_status like '%".$_REQUEST['keyword']."%' limit ".$page_first_result.','.$resultsPerPage);
                  $sql->execute();

                  while($search = $sql->fetchAll()) {

                    foreach ($search as $result)
                    {

                      if(isset($_GET["page"]) == "")
                      {
                        $pg = 1;
                      }

                      else
                      {
                        $pg = $_GET["page"];
                      }

                   }

                  echo "<tr>";
                  echo "<td>".$result['order_table']."</td>";
                  echo "<td>".$result['order_number']."</td>";
                  echo "<td>".$result['order_date']."</td>";
                  echo "<td>".$result['order_time']."</td>";
                  echo "<td>".$result['order_waiter']."</td>";
                  echo "<td>".$result['order_status']."</td>";


                  echo "<td>";
                  echo "<div class='row'>
                  <div class='col-md-2'>

                  <form method='post' action=''>

                  <button type='submit' class='btn btn-danger' name='delete' id='delete'  onclick='return delete_order();'>Delete</button></a>

                  </form>
                  </div>

                  <div class='col-md-2 ml-4'>

                   <form method='post' action='view_bill.php?order_table=".$result['order_table']."&order_number=".$result['order_number']."&order_cashier=".$userType."'>

                   <button type='submit' class='btn btn-warning' name='view' id='view'>View</button></a>

                   </form>
                   </div>";

                  echo "</td>";

                  echo "</tr>";


                 }

               }

               else
               {

               $query = $conn->prepare("select * from order_table limit ". $page_first_result . ',' . $resultsPerPage);
               $query->execute();
               while($orders = $query->fetchAll())
               {
                      foreach ($orders as $order)
                      {

                        if(isset($_GET["page"]) == "")
                        {
                          $pg = 1;
                        }

                        else
                        {
                          $pg = $_GET["page"];
                        }



                   echo "<tr>";
                   echo "<td>".$order['order_table']."</td>";
                   echo "<td>".$order['order_number']."</td>";
                   echo "<td>".$order['order_date']."</td>";
                   echo "<td>".$order['order_time']."</td>";
                   echo "<td>".$order['order_waiter']."</td>";
                   echo "<td>".$order['order_status']."</td>";


                   echo "<td>";
                   echo "<div class='row'>
                   <div class='col-md-2'>

                   <form method='post' action=''>

                   <button type='submit' class='btn btn-danger' name='delete' id='delete'  onclick='return delete_order();'>Delete</button></a>

                   </form>
                   </div>

                   <div class='col-md-2 ml-4'>

                   <form method='post' action='view_bill.php?order_table=".$order['order_table']."&order_number=".$order['order_number']."&order_cashier=".$userType."'>

                   <button type='submit' class='btn btn-warning' name='view' id='view'>View</button></a>

                   </form>
                   </div>";

                   if($order['order_status'] == 'Completed')
                   {

                   "<div class='col-md-2'>

                   <form method='post' action='print.php?id=".$order['restaurant_id']."&orderid=".ltrim($order['order_table'],"Table ")."'>

                   <button type='submit' class='btn btn-primary' name='print' id='print'>Print</button></a>

                   </form>
                   </div>";

                 }


                   echo "</td>";

                   echo "</tr>";




                  }

                }

              }

                    ?>


             </tbody>



            </table>

            </div>

            </div>

        </div>

        </div>


        </div>

      </div>
      <footer class="main-footer">

        <div class="footer-right">
        <nav aria-label="Page navigation example">
        <form method="POST">
        <ul class="pagination">

        <li class="page-item"><button type="submit" name="previous_page" id="previous_page" class="btn btn-warning mr-2">Previous</button></li>
        <?php

          for($page=1;$page<=$numberOfPages;$page++)
          {

              echo '<li class="page-item"><a class="page-link" href="cashier.php?page='.$page.'">'.$page.'</a></li>';

          }

      ?>
        <li class="page-item"><button type="submit" name="next_page" id="next_page" class="btn btn-success ml-2">Next</button></li>
        </ul>
        </form>
        </nav>
        </div>
      </footer>
    </div>
  </div>



<?php include_once "bin/bottompart4pages.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>

</body>
</html>
