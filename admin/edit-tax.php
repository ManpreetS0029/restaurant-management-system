<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
$_POST = array_map('trim', $_POST);

 
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

      

        <h2>Edit Tax</h2>

        <div class="bg mt-4">
        

            <div class="row ">

            <div class="col-md-4">

            <form method="POST" id="editTax"  name="editTax" action="form-insert/editTax.php?page=<?php echo $_GET['page']."&id=".$_GET['id']."&taxname=".$_GET['taxname']."&taxpercentage=".$_GET['taxpercentage']; ?>">
      
        
      <div class="row mt-4">
      
      <div class="col">
      <label for="tax_name">Tax Name</label>
      <input type="text" name="tax_name" id="tax_name" class="form-control" value="<?php echo $_GET['taxname']; ?>">
      
    </div>
</div>
  
<div class="row mt-4">
      
      <div class="col">
      <label for="tax_percentage">Tax Percentage</label>
      <input type="text" name="tax_percentage" id="tax_percentage" class="form-control" value="<?php echo $_GET['taxpercentage']; ?>">
      
    </div>
</div>
  

<div class="row mt-4">
    <div class="col">
  <button type="submit" name="edit_tax" id="edit_tax" class="btn btn-info" style="border-radius: 0px;">Save</button>
    </div>
</div>

</form>

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
<script>
  $(function() {

$("#editTax").validate({

  rules: {
    tax_name: {
      required: {
        depends: function(){
          $(this).val($.trim($(this).val()));
          return true;
        }

      },
      tax_name: true
        },
    action: "required",

    tax_percentage: {
      required: {
        depends: function(){
          $(this).val($.trim($(this).val()));
          return true;
        }

      },
      tax_percentage: true
        },
    action: "required"
    

  },
  messages: {
    tax_name: {
      required: "Tax name is required"
    },
    action: "Please provide some data",
    tax_percentage: {
      required: "Tax percentage is required"
    },
    action: "Please provide some data"

  }

 
});
});

</script>

</body>
</html>