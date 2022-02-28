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
            <a href="dashboard.php">  <i data-feather="users"></i> <span
                class="logo-name">Admin</span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">

      <h2>Edit Category</h2>

      <div class="row">
            <div class="col">
              <div class="bg">

            <form method="POST" id="editCategoryForm"  name="editCategoryForm" action="form-insert/editCategory.php?page=<?php echo $_GET['page'].'&id='.$_GET['id']; ?>">
      

            <div class="row mt-4">  
            
            <div class="col-md-4">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $_GET['name']; ?>">
            
          </div>
</div>
        
      <div class="row mt-4">
        <div class="col">
        <button type="submit" name="edit_category" id="edit_category" class="btn btn-info" style="border-radius: 0px;">Save</button>
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

$("#editCategoryForm").validate({

  rules: {
    category_name: {
      required: {
        depends: function(){
          $(this).val($.trim($(this).val()));
          return true;
        }

      },
      category_name: true
        },
    action: "required"
  },
  messages: {
    category_name: {
      required: "Category name is required"
    },
    action: "Please provide some data"
  }
});
});


</script>

</body>
</html>