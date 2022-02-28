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

$getCategory = $conn->prepare("select * from product_category_table");
$getCategory->execute();
$fetchCategory = $getCategory->fetchAll();

$getProductCategory = $conn->prepare("select * from product_table where product_name = ?");
$getProductCategory->execute(array($_GET["prodname"]));
$fetchProductCategory = $getProductCategory->fetchAll();
    
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
        

        <div class="bg mt-4">

        <h2>Edit Order</h2>

        <div class="row">
            <div class="col">
            

            <form method="POST" id="editOrderForm" name="editOrderForm" action="form-insert/editOrder.php?id=<?php echo $_SESSION["restaurant_id"].'&tbl_name='.$_GET["tbl_name"].'&user_id='.$_SESSION["user_id"]; ?>">

        <div class="row mt-4">

        <div class="col-md-5">
            <label for="category_name">Category</label>
            <select class="custom-select category" name="category_name" id="category_name">
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

        <div class="col-md-5" id="response">
            
        </div>


        </div>

        <div class="row mt-4">

        <div class="col-md-5">
            <label for="item_quantity">Quantity</label>
            <input type="number" name="item_quantity" id="item_quantity" class="form-control" value="<?php echo $_GET['quantity']; ?>">
        </div>


        </div>

        <div class="row mt-4">
             <div class="col-md-5">
             <button type="submit" name="add_order" id="add_order" class="btn btn-info" style="border-radius: 0px;">Save</button>
             </div>    
        </div>

      
            </form>
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
        url: "./script.php",
        data: {category: selectedCategory}
      }
    ).done(function(data){
    $("#response").html(data);
  });
});
});


function delete_order()
{
  return confirm("Do you really want to delete this order ?");
}


</script>
</body>
</html>