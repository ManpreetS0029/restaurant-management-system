<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
include_once "bin/pagination.php";

$_POST = array_map('trim', $_POST);

$query = $conn->prepare("select * from user_table where user_id  = ?");
$query->execute(array($_GET["id"]));
$getUser = $query->fetchAll();
 
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


      <h1>Edit User</h1>
        
          <div class="bg mt-4">

          <div class="row">
            <div class="col-md-4">

            <form method="POST" id="editUserForm"  name="editUserForm" action="form-insert/editUser.php?id=<?php echo $_GET['id']; ?>" enctype="multipart/form-data">
      
            <?php

            foreach($getUser as $user)
            {
            ?>
        
            <div class="row mt-4">
             
            <div class="col">
            <label for="user_name">User Name</label>
            <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $user["user_name"]; ?>">
            
          </div>
          </div>

            <div class="row mt-4">
            
            <div class="col">
            <label for="user_contact_no">User Contact No</label>
            <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" value="<?php echo $user["user_contact_no"]; ?>">
            
            </div>
            </div>

            <div class="row mt-4">
            
            <div class="col">
            <label for="user_email">User Email</label>
            <input type="email" name="user_email" id="user_email" class="form-control" value="<?php echo $user["user_email"]; ?>">
            
            </div>
            </div>

            <div class="row mt-4">
            
            <div class="col">
            <label for="user_password">User Password</label>
            <input type="password" name="user_password" id="user_password" class="form-control" value="<?php echo $user["user_password"]; ?>">
            
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

            <?php
            
              if($user["user_profile"] != "")
              {

                $value = $user["user_profile"];
              
            ?>
            <div class="row mt-4">
                <div class="col">
                    <img src="<?php echo 'uploads/dp/'.$user['user_profile']; ?>" height="150" width="150">
                </div>
            </div>

            <?php 
              }
            ?>
            <div class="row mt-4">
            
            <div class="col">
            <label for="user_profile">User Profile</label>
            <input type="file" name="user_profile" id="user_profile" class="form-control-file" accept=".jpg,.jpeg,.png,.gif" value="<?php if($value != ""){echo $value;} ?>">

            
            </div>
            </div>
        
      <div class="row mt-4">
        <div class="col">
        <button type="submit" name="edit_user" id="edit_user" class="btn btn-info" style="border-radius: 0px;">Save</button>
        </div>
      </div>

      <?php 

            }      

      ?>

      </form>

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

$("#editUserForm").validate({

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

</script>

</body>
</html>