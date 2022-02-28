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
    header("Location: add_order.php?page=".$previous."&tbl_name=".$_GET['tbl_name']);
    }
  }
  else if($_GET["page"] == 0)
  {
    header("Location: add_order.php?page=1&tbl_name=".$_GET['tbl_name']);
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
      header("Location: add_order.php?page=".$nextPage."&tbl_name=".$_GET['tbl_name']);
  }
  else
  {
    header("Location: add_order.php?page=2&tbl_name=".$_GET['tbl_name']);
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

  else
  {
        $userType = "Cashier";
  }
}

if(isset($_POST["delete"]))
{
  $query = $conn->prepare("delete from order_item_table where order_id = ? and product_name = ?");
  $query->execute(array($_GET["id"],$_GET["item"]));

  $orderStatus = $conn->prepare("select * from order_item_table where order_id = ?");
  $orderStatus->execute(array($_GET["id"]));
  $currentOrdStatus = $orderStatus->fetch(PDO::FETCH_ASSOC);

  if(!$currentOrdStatus)
  {
    $updateOrderTable = $conn->prepare("update order_table set order_status = ? where order_id = ?");
    $updateOrderTable->execute(array("Completed",$_GET["id"]));
  }

}

$getCategory = $conn->prepare("select * from product_category_table");
$getCategory->execute();
$fetchCategory = $getCategory->fetchAll();
    
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
                class="logo-name"><?php echo $userType; ?></span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>

      

      <!-- Main Content -->
      <div class="main-content">


      <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col">
            

            <form method="POST" id="addOrderForm" name="addOrderForm" action="form-insert/addOrder.php?id=<?php echo $_SESSION["restaurant_id"].'&tbl_name='.$_GET["tbl_name"].'&user_id='.$_SESSION["user_id"]; ?>">

        <div class="row mt-4">

        <div class="col">
            <label for="category_name">Category</label>
            <select class="custom-select category" name="category_name" id="category_name">
                <option>select</option>
                <?php
                 foreach($fetchCategory as $category)
                 {
                     echo "<option value='".$category["category_name"]."'>".$category["category_name"]."</option>";
                 }   

                ?>
            </select>
        </div>


        </div>

        <div class="row mt-4">

        <div class="col" id="response">
            
        </div>


        </div>

        <div class="row mt-4">

        <div class="col">
            <label for="item_quantity">Quantity</label>
            <input type="number" name="item_quantity" id="item_quantity" class="form-control">
        </div>


        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_order" id="add_order" class="btn btn-info" style="border-radius: 0px;">Save</button>
      </div>
            </form>
    </div>
  </div>
</div>
    </div>
  </div>
</div>

        <h2>Order Management</h2>

        <div class="bg mt-4">

        <div class="row mt-4">    
         <div class="col-md-11">
           <h3>Order Status</h3>
         </div>

         <div class="col">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="font-size: 22px;">
  +
        </button>
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
             $orderId = ltrim($_GET["tbl_name"],"Table");
             $query = $conn->prepare("select * from order_item_table where order_id = $orderId limit ". $page_first_result . ',' . $resultsPerPage);
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
                 echo "<td>".$order['product_name']."</td>";     
                 echo "<td>".$order['product_quantity']."</td>";
                 echo "<td>".$order['product_rate']."</td>";
                 echo "<td>".$order['product_amount']."</td>";
                  
                 
                 echo "<td>";
                 echo "<div class='row'>
                 <div class='col-md-2'>
                 
                 <form method='post' action='add_order.php?page=".$pg."&id=".$order['order_id']."&item=".$order['product_name']."&tbl_name=".$_GET['tbl_name']."'>

                 <button type='submit' class='btn btn-danger' name='delete' id='delete'  onclick='return delete_order();'>Delete</button></a>

                 </form> 
                 </div>
                 
                 <div class='col-md-2 ml-4'>

                 <form method='post' action='edit_order.php?page=".$pg."&id=".$order['order_id']."&tbl_name=".$_GET['tbl_name']."&quantity=".$order["product_quantity"]."&prodname=".$order["product_name"]."'>

                 <button type='submit' class='btn btn-warning' name='edit' id='edit'>Edit</button></a>

                 </form>
                 </div>";

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
        <nav aria-label="Page navigation example">
        <form method="POST">
        <ul class="pagination">
          
        <li class="page-item"><button type="submit" name="previous_page" id="previous_page" class="btn btn-warning mr-2">Previous</button></li>
        <?php 
        
          for($page=1;$page<=$numberOfPages;$page++)
          {

                echo '<li class="page-item"><a class="page-link" href="add_order.php?page='.$page.'&tbl_name='.$_GET['tbl_name'].'">'.$page.'</a></li>';
  
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
<script>
  $(function() {

    $("#addOrderForm").validate({

rules: {
    item_name: {
    required: {
      depends: function(){
        $(this).val($.trim($(this).val()));
        return true;
      }

    },
    item_name: true
      },
  action: "required",

  item_quantity: {
    required: {
      depends: function(){
        $(this).val($.trim($(this).val()));
        return true;
      }

    },
    item_quantity: true
      },
  action: "required",

  category_name: {required: true , min:0}

},
messages: {
  product_name: {
    required: "Product name is required"
  },
  action: "Please provide some data",

  product_price: {
    required: "Product price is required"
  },
  action: "Please provide some data"
}


});
});

$(document).ready(function(){
  $("select.category").change(function(){
    var selectedCategory = $(".category option:selected").val();
    $.ajax(
      {
        type: "POST",
        url: "script.php",
        data: {category: selectedCategory}
      }
    ).done(function(data){
    $("#response").html(data);
  });
});
});


function delete_order()
{
  return confirm("Do you really want to delete this item ?");
}


</script>
</body>
</html>