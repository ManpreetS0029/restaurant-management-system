<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
require_once "models/add_product_model.php";
include_once "bin/pagination.php";
$_POST = array_map('trim', $_POST);

$query = $conn->prepare("select * from product_category_table");
$query->execute();
$rows = $query->fetchAll();

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
            <a href="dashboard.php">  <i data-feather="users"></i> <span
                class="logo-name">Admin</span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>



      <!-- Main Content -->
      <div class="main-content">

        <h2>Edit Product</h2>

        <div class="bg mt-4">

        <div class="row">

        <div class="col">



            <div class="row mt-4">

            <div class="col-md-4">

            <form method="POST" id="editProduct" name="editProduct" action="form-insert/editProduct.php?page=<?php echo $_GET["page"]."&id=".$_GET["id"]."&catname=".$_GET["catname"]."&prodname".$_GET["prodname"]."&prodprice=".$_GET["prodprice"]; ?>">

        <div class="row mt-4">

        <div class="col">
            <label for="category_name">Category</label>
            <select class="custom-select" name="category_name" id="category_name">
                <option>select</option>

                <?php

                foreach($rows as $index=>$cat)
                {

                  if($cat['category_name'] === $_GET['catname'])
                  {

                   echo "<option selected='selected'>".$cat['category_name']."</option>";

                  }


                }

                $filterCat = $conn->prepare("select * from product_category_table where category_name != ?");
                $filterCat->execute(array($_GET["catname"]));
                $category = $filterCat->fetchAll();

                foreach($category as $ctgory)
                {
                  echo "<option>".$ctgory['category_name']."</option>";
                }

                ?>
            </select>
        </div>


        </div>

        <div class="row mt-4">

        <div class="col">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $_GET["prodname"]; ?>">
        </div>


        </div>

        <div class="row mt-4">

        <div class="col">
            <label for="product_price">Product Price</label>
            <input type="text" name="product_price" id="product_price" class="form-control"  value="<?php echo $_GET["prodprice"]; ?>">
        </div>


        </div>

      <div class="row mt-4">
          <div class="col">

        <button type="submit" name="edit_product" id="edit_product" class="btn btn-info" style="border-radius: 0px;">Save</button>

          </div>
      </div>
            </form>

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
  $(function() {

    $("#editProduct").validate({

rules: {
  product_name: {
    required: {
      depends: function(){
        $(this).val($.trim($(this).val()));
        return true;
      }

    },
    product_name: true
      },
  action: "required",

  product_price: {
    required: {
      depends: function(){
        $(this).val($.trim($(this).val()));
        return true;
      }

    },
    product_price: true
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

</script>
</body>
</html>
