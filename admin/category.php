<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";

$_POST = array_map('trim', $_POST);

$sql = $conn->prepare("select * from product_category_table");
$sql->execute();
$numberOfResults = $sql->rowCount();

/*
$getParentCat = $conn->prepare("select * from product_category_table where parent_category_id = 0");
$getParentCat->execute();
$fetchParentCat = $sql->fetchAll();
*/

//echo $numberOfResults;

//pagination code
$numberOfPages = ceil($numberOfResults/$resultsPerPage);
$page_first_result = ($page-1)*$resultsPerPage;


//to enable category
if(isset($_POST["active"]))
{
    $activeCat = $conn->prepare("update product_category_table set category_status = 'Enable' where category_id = ?");
    $activeCat->execute(array($_GET["id"]));
}

//to disable category
if(isset($_POST["deactive"]))
{
  $deactiveCat = $conn->prepare("update product_category_table set category_status = 'Disable' where category_id = ?");
  $deactiveCat->execute(array($_GET["id"]));
}

if(isset($_POST["delete"]))
{
  $deleteCategory = $conn->prepare("delete from product_category_table where category_id = ?");
  $deleteCategory->execute(array($_GET["id"]));
}

if(isset($_POST["previous_page"]))
{
  $previous = $_GET["page"] - 1;

  if($_GET["page"] != "")
  {
    if($previous > 0)
    {
    header("Location: category.php?page=".$previous);
    }
  }
  else if($_GET["page"] == 0)
  {
    header("Location: category.php?page=1");
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
      header("Location: category.php?page=".$nextPage);
  }
  else
  {
    header("Location: category.php?page=2");
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
            <a href="dashboard.php"><i data-feather="users"></i>   <span
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
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col">

            <form method="POST" id="addCategoryForm"  name="addCategoryForm" action="form-insert/addCategory.php?id=<?php echo $_SESSION['user_id']; ?>">


            <div class="row mt-4">

            <div class="col">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control" >

          </div>
</div>



      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_category" id="add_category" class="btn btn-info" style="border-radius: 0px;">Save</button>
      </div>

      </form>

    </div>
  </div>
      </div>
    </div>
  </div>
      </div>

        <h2>Category Management</h2>

        <div class="bg mt-4">
        <div class="row mt-4">
         <div class="col-md-11">
           <h3>Category List</h3>
         </div>

         <div class="col">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="font-size: 22px;">+</button>
         </div>

        </div>

          <!-- Table -->
            <div class="row mt-4">

            <div class="col">

            <table class="table table-striped">

             <thead>
                 <tr>
                     <th scope="col">Category Name</th>
                     <th scope="col">Status</th>
                     <th scope="col">Actions</th>

                 </tr>
             </thead>

             <tbody>

             <?php

                $query = $conn->prepare("select * from product_category_table group by category_name limit ". $page_first_result . ',' . $resultsPerPage);
                $query->execute();

                while($rows = $query->fetchAll())
                {

                    foreach ($rows as $row)
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


                 echo "<td>";

                 echo $row['category_name'];

                 echo "</td>";

                 if($row['category_status'] === "Enable")
                 {
                 echo "<form method='post' action='category.php?page=".$pg."&id=".$row['category_id']."'>";
                 echo "<td><button type='submit' class='btn btn-danger' name='deactive' id='deactive'>Deactivate</button></a></td>";
                 echo "</form>";
                 }

                 else if($row['category_status'] === "Disable")
                 {
                  echo "<form method='post' action='category.php?page=".$pg."&id=".$row['category_id']."'>";
                  echo "<td><button type='submit' class='btn btn-success' name='active'>Activate</button></a></td>";
                  echo "</form>";
                 }

                 echo "<td>
                 <div class='row'>
                 <div class='col-md-2'>

                 <form method='post' action='category.php?page=".$pg."&id=".$row['category_id']."'>

                 <button type='submit' class='btn btn-danger' name='delete' id='delete' onclick='return delete_category();'>Delete</button></a>

                 </form>
                 </div>

                 <div class='col-md-2'>

                 <form method='post' action='edit-category.php?page=".$pg."&id=".$row['category_id']."&name=".$row['category_name']."'>

                 <button type='submit' class='btn btn-warning' name='edit' id='edit'>Edit</a>

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

                echo '<li class="page-item"><a class="page-link" href="category.php?page='.$page.'">'.$page.'</a></li>';

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

$("#addCategoryForm").validate({

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


function delete_category()
{
  return confirm("Do you really want to delete this category ?");
}


</script>


</body>
</html>
