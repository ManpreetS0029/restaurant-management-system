<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";

$_POST = array_map('trim', $_POST);

$tableCapacity = array("1 Person","2 Persons","3 Persons","4 Persons","5 Persons","6 Persons","7 Persons","8 Persons","9 Persons","10 Persons","11 Persons","12 Persons","13 Persons","14 Persons","15 Persons","16 Persons","17 Persons","18 Persons","19 Persons","20 Persons");

$getTable = $conn->prepare("select * from table_data ");
$getTable->execute();
$tables = $getTable->fetchAll();
$numberOfResults = $getTable->rowCount();

//pagination code
$numberOfPages = ceil($numberOfResults/$resultsPerPage);
$page_first_result = ($page-1)*$resultsPerPage;

if(isset($_POST["active"]))
{
    $activeCat = $conn->prepare("update table_data set table_status = 'Enable' where table_id = ?");
    $activeCat->execute(array($_GET["id"]));
}

if(isset($_POST["deactive"]))
{
  $deactiveCat = $conn->prepare("update table_data set table_status = 'Disable' where table_id = ?");
  $deactiveCat->execute(array($_GET["id"]));
}

if(isset($_POST["delete"]))
{
  $deleteCategory = $conn->prepare("delete from table_data where table_id = ?");
  $deleteCategory->execute(array($_GET["id"]));
}

if(isset($_POST["previous_page"]))
{
  $previous = $_GET["page"] - 1;
  
  if($_GET["page"] != "")
  {
    if($previous > 0)
    {
    header("Location: table.php?page=".$previous);
    }
  }
  else if($_GET["page"] == 0)
  {
    header("Location: table.php?page=1");
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
      header("Location: table.php?page=".$nextPage);
  }
  else
  {
    header("Location: table.php?page=2");
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
            <a href="dashboard.php">  <i data-feather="users"></i> <span
                class="logo-name">Admin</span>
            </a>
          </div>

          <?php include_once "bin/sidebar.php";?>

        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Table</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col">

            <form method="POST" id="addTable"  name="addTable" action="form-insert/addTable.php?id=<?php echo $_SESSION['user_id']; ?>">
      
        
            <div class="row mt-4">
            
            <div class="col">
            <label for="table_name">Table Name</label>
            <input type="text" name="table_name" id="table_name" class="form-control" >
            
          </div>
</div>
        
<div class="row mt-4">
            
            <div class="col">
            <label for="table_capacity">Table Capacity</label>
            <select name="table_capacity" id="table_capacity" class="custom-select">
                <option value="-1">select</option>
                <?php foreach($tableCapacity as $capacity)
                {
                  echo "<option>".$capacity."</option>";
                }
                ?>
            </select>
            
          </div>
</div>
        
  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_table" id="add_table" class="btn btn-info" style="border-radius: 0px;">Save</button>
      </div>

      </form>

    </div>
  </div>
      </div>
    </div>
  </div>
      </div>

        <h2>Table Management</h2>

        <div class="bg mt-4">
        <div class="row mt-4">    
         <div class="col-md-11">
           <h3>Table List</h3>
         </div>
           
         <div class="col">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="font-size: 22px;">+</button>
         </div>
         
        </div>

            <div class="row mt-4">

            <div class="col">

            <table class="table table-striped">
               
             <thead>
                 <tr>
                     <th scope="col">Table Name</th>
                     <th scope="col">Table Capacity</th>
                     <th scope="col">Status</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>
             
             <tbody>

             <?php
             $query = $conn->prepare("select * from table_data limit ". $page_first_result . ',' . $resultsPerPage);
             $query->execute();
             while($tables = $query->fetchAll())
             {
                    foreach ($tables as $table)
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
                 echo "<td>".$table['table_name']."</td>";     
                 echo "<td>".$table['table_capacity']." Persons</td>";
                 if($table['table_status'] === "Enable")
                 {  
                 echo "<form method='post' action='table.php?page=".$pg."&id=".$table['table_id']."'>";  
                 echo "<td><button type='submit' class='btn btn-danger' name='deactive' id='deactive'>Deactivate</button></a></td>";
                 echo "</form>";
                 }
                 
                 else if($table['table_status'] === "Disable")
                 {
                  echo "<form method='post' action='table.php?page=".$pg."&id=".$table['table_id']."'>";  
                  echo "<td>
                  <button type='submit' class='btn btn-success' name='active'>Activate</button></a></td>";
                  echo "</form>";
                 }
                 echo "<td>";
                 echo "<div class='row'>
                 <div class='col-md-2'>
                 
                 <form method='post' action='table.php?page=".$pg."&id=".$table['table_id']."'>

                 <button type='submit' class='btn btn-danger' name='delete' id='delete' onclick='return delete_table();'>Delete</button></a>

                 </form> 
                 </div>
                 
                 <div class='col-md-2 ml-2'>

                 <form method='post' action='edit-table.php?page=".$pg."&id=".$table['table_id']."&tblname=".$table['table_name']."&tblcapacity=".$table['table_capacity']."'>

                 <button type='submit' class='btn btn-warning' name='edit' id='edit'>Edit</button></a>

                 </form>
                 </div>
                 </div>
                 </td>";
                 
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

                echo '<li class="page-item"><a class="page-link" href="table.php?page='.$page.'">'.$page.'</a></li>';
  
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

$("#addTable").validate({

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

  function delete_table()
{
  return confirm("Do you really want to delete this table ?");
}
</script>

</body>
</html>