<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";


$_POST = array_map('trim', $_POST);

$sql = $conn->prepare("select * from user_table");
$sql->execute();
$numberOfResults = $sql->rowCount();

//pagination code
$numberOfPages = ceil($numberOfResults/$resultsPerPage);
$page_first_result = ($page-1)*$resultsPerPage;


//to enable category
if(isset($_POST["active"]))
{
    $activeCat = $conn->prepare("update user_table set user_status = 'Enable' where user_id = ?");
    $activeCat->execute(array($_GET["id"]));
}

//to disable category
if(isset($_POST["deactive"]))
{
  $deactiveCat = $conn->prepare("update user_table set user_status = 'Disable' where user_id = ?");
  $deactiveCat->execute(array($_GET["id"]));
}

if(isset($_POST["delete"]))
{
  $deleteCategory = $conn->prepare("delete from user_table where user_id = ?");
  $deleteCategory->execute(array($_GET["id"]));
}

if(isset($_POST["previous_page"]))
{
  $previous = $_GET["page"] - 1;

  if($_GET["page"] != "")
  {
    if($previous > 0)
    {
    header("Location: user.php?page=".$previous);
    }
  }
  else if($_GET["page"] == 0)
  {
    header("Location: user.php?page=1");
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
      header("Location: user.php?page=".$nextPage);
  }
  else
  {
    header("Location: user.php?page=2");
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
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
            <div class="col">

            <form method="POST" id="addUserForm"  name="addUserForm" action="form-insert/addUser.php?id=<?php echo $_SESSION['user_id']; ?>" enctype="multipart/form-data">


            <div class="row mt-4">

            <div class="col">
            <label for="user_name">User Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" >

          </div>
          </div>

            <div class="row mt-4">

            <div class="col">
            <label for="user_contact_no">User Contact No</label>
            <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" >

            </div>
            </div>

            <div class="row mt-4">

            <div class="col">
            <label for="user_email">User Email</label>
            <input type="email" name="user_email" id="user_email" class="form-control" >

            </div>
            </div>

            <div class="row mt-4">

            <div class="col">
            <label for="user_password">User Password</label>
            <input type="password" name="user_password" id="user_password" class="form-control" >

            </div>
            </div>

            <div class="row mt-4">

            <div class="col">
            <label for="user_type">User Type</label>

            <select name="user_type" id="user_type" class="custom-select" >
            <option value="waiter">Waiter</option>
            <option value="cashier">Cashier</option>
            </select>

            </div>
            </div>

            <div class="row mt-4">

            <div class="col">
            <label for="user_profile">User Profile</label>
            <input type="file" name="user_profile" id="user_profile" class="form-control-file" accept=".jpg,.jpeg,.png,.gif">


            </div>
            </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_user" id="add_user" class="btn btn-info" style="border-radius: 0px;">Save</button>
      </div>

      </form>

    </div>
  </div>
      </div>
    </div>
  </div>
      </div>

        <h2>User Management</h2>
          <div class="bg mt-4">
        <div class="row mt-4">
         <div class="col-md-11">
           <h3 class="text-black">User List</h3>
         </div>

         <div class="col">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="font-size:22px;" >+</button>
         </div>

        </div>


          <!-- Table -->

          <div class="row mt-4">

            <div class="col">

            <table class="table table-striped">

             <thead>
                 <tr>
                     <th scope="col">Image</th>
                     <th scope="col">User Name</th>
                     <th scope="col">User Contact No</th>
                     <th scope="col">User Email</th>
                     <th scope="col">User Type</th>
                     <th scope="col">Created On</th>
                     <th scope="col">Status</th>
                     <th scope="col">Actions</th>
                 </tr>
             </thead>

             <tbody>

            <?php

             $query = $conn->prepare("select * from user_table where restaurant_id = '".$_SESSION['user_id']."' and user_type != 'Master' limit ". $page_first_result . ',' . $resultsPerPage);
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
                 if($row["user_profile"] != "")
                 {
                 echo "<td><img src='uploads/dp/".$row["user_profile"]."' style='width:50px;height:50px;'></td>";
                 }

                 else
                 {
                  echo "<td><img src='uploads/dp/user.png' style='width:50px;height:50px;'></td>";
                 }
                 echo "<td>".$row['user_name']."</td>";
                 echo "<td>".$row['user_contact_no']."</td>";
                 echo "<td>".$row['user_email']."</td>";
                 echo "<td>".$row['user_type']."</td>";
                 echo "<td>".$row['user_created_on']."</td>";
                 if($row['user_status'] === "Enable")
                 {
                 echo "<form method='post' action='user.php?page=".$pg."&id=".$row['user_id']."'>";
                 echo "<td><button type='submit' class='btn btn-danger' name='deactive' id='deactive'>Deactivate</button></a></td>";
                 echo "</form>";
                 }

                 else if($row['user_status'] === "Disable")
                 {
                  echo "<form method='post' action='user.php?page=".$pg."&id=".$row['user_id']."'>";
                  echo "<td><button type='submit' class='btn btn-success' name='active'>Activate</button></a></td>";
                  echo "</form>";
                 }

                 echo "<td>
                 <div class='row'>
                 <div class='col-md-2'>

                 <form method='post' action='user.php?page=".$pg."&id=".$row['user_id']."'>

                 <button type='submit' class='btn btn-danger' name='delete' id='delete' onclick='return delete_user();'>Delete</button></a>

                 </form>
                 </div>

                 <div class='col-md-2' style='margin-left:35px;'>

                 <form method='post' action='edit-user.php?page=".$pg."&id=".$row['user_id']."&name=".$row['user_name']."'>

                 <button type='submit' class='btn btn-warning' name='edit' id='edit' >Edit</a>

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

      <footer class="main-footer">
        <div class="footer-right">
        <nav aria-label="Page navigation example">
        <form method="POST">
        <ul class="pagination">

        <li class="page-item"><button type="submit" name="previous_page" id="previous_page" class="btn btn-warning mr-2">Previous</button></li>
        <?php

          for($page=1;$page<=$numberOfPages;$page++)
          {

                echo '<li class="page-item"><a class="page-link" href="user.php?page='.$page.'">'.$page.'</a></li>';

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

$("#addUserForm").validate({

rules: {
  user_name: {
  required: {
  depends: function(){
    $(this).val($.trim($(this).val()));
    return true;
  }

},
user_name: true
  },
action: "required",

user_contact_no: {
required: {
  depends: function(){
    $(this).val($.trim($(this).val()));
    return true;
  }

},
user_contact_no: true
  },
action: "required",

user_email: {
required: {
  depends: function(){
    $(this).val($.trim($(this).val()));
    return true;
  }

},
user_email: true
  },
action: "required",

user_password: {
required: {
  depends: function(){
    $(this).val($.trim($(this).val()));
    return true;
  }

},
user_password: true
  },
action: "required",

user_profile: { required: true, extension: "png|jpe?g|gif", filesize: 1000000  }

},
messages: {
user_name: {
required: "User name is required"
},
action: "Please provide some data",

user_contact_no: {
required: "User contact no is required"
},
action: "Please provide some data",

user_email: {
required: "User email is required"
},
action: "Please provide some data",

user_password:  {
required: "User password is required"
},
action: "Please provide some data",

user_profile: {
   required: "File must be JPG, GIF or PNG, less than 1MB"
 },
 action: "Please provide some data"

}



});
});

function delete_user()
{
  return confirm("Do you really want to delete this user ?");
}
</script>

</body>
</html>
