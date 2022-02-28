<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";

$_POST = array_map('trim', $_POST);
$getOrder = $conn->prepare("select * from order_item_table where order_id = ?");
$getOrder->execute(array(ltrim($_GET["order_table"],"Table ")));

/*
$get_tax_tbl = $conn->prepare("select * from tax_table");
$get_tax_tbl->execute();
$tbl_tax = $get_tax_tbl->fetchColumn();

echo ($tbl_tax);
*/

if(isset($_POST["delete"]))
{
  $delete_item = $conn->prepare("delete from order_item_table where order_id = ? and product_name = ?");
  $delete_item->execute(array(ltrim($_GET["order_table"],"Table "),$_GET["product"]));

  $query = $conn->prepare("select sum(product_amount) as prod_amount from order_item_table where order_id = ?");
  $query->execute(array(trim($_GET["order_table"],"Table ")));
  $getOrderItems = $query->fetch(PDO::FETCH_ASSOC);

  $grossItemPrice = $getOrderItems["prod_amount"];
  $updateOrderTable = $conn->prepare("update order_table set order_gross_amount = ? where order_table = ? ");
  $updateOrderTable->execute(array($grossItemPrice,$_GET["tbl_name"]));
  header("Location: ../add_order.php?id=".$restaurant_id."&tbl_name=".$_GET["tbl_name"]);

  $sum_of_tax = $conn->prepare("select sum(tax_percentage) as tax from tax_table");
  $sum_of_tax->execute();
  $tax = $sum_of_tax->fetch(PDO::FETCH_ASSOC);

  $order_tax_amount = ($getOrderItems["prod_amount"] * $tax["tax"]) / 100;
  $order_net_amount = $getOrderItems["prod_amount"] + $order_tax_amount ;
  
  
  $update_order = $conn->prepare("update order_table set order_tax_amount = ? , order_net_amount = ? where order_table = ?");
  $update_order->execute(array($order_tax_amount,$order_net_amount,$_GET["tbl_name"]));

  $select_ord_tx_amt = $conn->prepare("select sum(order_tax_amount) as amt from order_table where order_table = ? ");
  $select_ord_tx_amt->execute(array($_GET["tbl_name"]));
  $order_tax_amount = $select_ord_tx_amt->fetch(PDO::FETCH_ASSOC);

  $tax_amt = $order_tax_amount["amt"] / 2;


  $update_ord_tx_tbl = $conn->prepare("update order_tax_table set order_tax_amount = ? where order_id = ?");
  $update_ord_tx_tbl->execute(array($tax_amt,ltrim($_GET["tbl_name"],"Table ")));

  

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

      <!-- Button trigger modal -->

        <h2>Order Bill</h2>

        <div class="bg mt-4">

        <div class="row mt-4">
         <div class="col-md-11">
           <h3>Bill</h3>
         </div>

         <div>
           <div class="col-md-1">
              <form action="print.php?id=<?php echo $_SESSION["user_id"].'&order_table='.$_GET['order_table'].'&order_number='.$_GET['order_number'].'&order_cashier='.$_GET['order_cashier']; ?>" method="post">
                <button type="submit" name="print"class="btn btn-success" >Print</button>
              </form>
           </div>
         </div>

        </div>

        <div class="row">

        <div class="col">



            <div class="row mt-4">

            <div class="col">

            <table class="table table-striped">

             <thead>
                 <tr>
                     <th scope="col">Item Name</th>
                     <th scope="col">Quantity</th>
                     <th scope="col">Rate</th>
                     <th scope="col">Amount</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>

             <tbody>

             <?php
             
             while($orders = $getOrder->fetchAll())
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
                 echo "<td>".$order['product_name']."</td>";
                 echo "<td>".$order['product_quantity']."</td>";
                 echo "<td>".$order['product_rate']."</td>";
                 echo "<td>".$order['product_amount']."</td>";


                 echo "<td>";
                 echo "<div class='row'>
                 <div class='col-md-2'>

                 <form method='post' action='view_bill.php?order_table=".$_GET['order_table']."&order_number=".$_GET['order_number']."&order_cashier=".$_GET['order_cashier']."&product=".$order['product_name']."'>

                 <button type='submit' class='btn btn-danger' name='delete' id='delete'  onclick='return delete_order();'>Delete</button></a>

                 </form>
                 </div>

                 ";

                 echo "</td>";

                 echo "</tr>";


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
        
        </div>
      </footer>
    </div>
  </div>



<?php include_once "bin/bottompart4pages.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>

<script>
  function delete_order()
{
  return confirm("Do you really want to delete this item ?");
}
</script>

</body>
</html>
