<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";

$tableCapacity = array("1 Person","2 Persons","3 Persons","4 Persons","5 Persons","6 Persons","7 Persons","8 Persons","9 Persons","10 Persons","11 Persons","12 Persons","13 Persons","14 Persons","15 Persons","16 Persons","17 Persons","18 Persons","19 Persons","20 Persons");


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

      <h2>Edit Table</h2>

        <div class="bg mt-4">
        <div class="row">
            <div class="col-md-4">

            <form method="POST" id="editTable"  name="editTable" action="form-insert/editTable.php?page=<?php echo $_GET['page'].'&id='.$_GET['id'].'&tblname'.$_GET['tblname'].'&tblcapacity'.$_GET['tblcapacity']; ?>">


            <div class="row mt-4">

            <div class="col">
            <label for="table_name">Table Name</label>
            <input type="text" name="table_name" id="table_name" class="form-control" value="<?php echo $_GET['tblname']; ?>" >

          </div>
</div>

<div class="row mt-4">

            <div class="col">
            <label for="table_capacity">Table Capacity</label>
            <select name="table_capacity" id="table_capacity" class="custom-select" >

               <option value="-1">select</option>

               <option selected="selected" value="<?php echo $_GET["tblcapacity"]; ?>"><?php echo $_GET["tblcapacity"]." Persons"; ?></option>

               <?php

               foreach($tableCapacity as $capacity)
                {

                  echo "<option value='".$capacity."'>".$capacity."</option>";

                }


                ?>
            </select>

          </div>
</div>


      <div class="row mt-4">
          <div class="col">
        <button type="submit" name="edit_table" id="edit_table" class="btn btn-info" style="border-radius: 0px;">Save</button>
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

$("#editTable").validate({

  rules: {
    table_name: {
      required: {
        depends: function(){
          $(this).val($.trim($(this).val()));
          return true;
        }

      },
      table_name: true
        },
    action: "required",

    table_capacity: {required: true , min:0}

  },
  messages: {
    table_name: {
      required: "Table name is required"
    },
    action: "Please provide some data"
  }


});
});

</script>

</body>
</html>
