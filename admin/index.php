<?php
require_once "appcode/db_connection.php";
include_once "validation/validation.php";


$msg = "";

$err = "";

$_POST = array_map('trim', $_POST);

if(isset($_POST["submit_button"]))
{
	$msg .= loginFrmValidation();

   array_map('trim', $_POST);
	if($msg == "1")
	{
		$email = $_POST['email'];
		$password = md5($_POST['password']);


		$sql = $conn->prepare("select * from user_table where user_email = ? and user_password = ? and user_type = ? ");

		$sql->execute(array($email,$password,"Master"));

		$row = $sql->fetch(PDO::FETCH_ASSOC);

		if(is_array($row))
		{
				session_start();
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['user_email'] = $row['user_email'];

		}
				else
				{



					$err .= "Invalid email or password";

				}

				}

				if(isset($_SESSION['user_id']))
				{
					header("Location: dashboard.php");
				}

			}


?>

<?php include_once "bin/toppart4pages.php"; ?>

<div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Restaurant Management System</h4>
              </div>
              <div class="card-body">
                <form method="POST" class="needs-validation" name="loginForm" novalidate="">
                <?php



if($msg != "") {

	if($msg == "1")
	{

}

else {

		?>


<div class="row">
			<div class="col text-center">

				<div class="alert alert-danger" id="loginMsg" style="display: block;">
					<?php echo $msg;


					?>
				</div>

			</div>
		</div>


		<?php }

}



		if($err != "")
		{

		?>


<div class="row ">
			<div class="col text-center">

				<div class="alert alert-danger" id="errMsg">
					<?php echo $err;


					?>
				</div>

			</div>
		</div>


		<?php } ?>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <button type="submit" name="submit_button" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
               
                
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="register.php">Create One</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>



 <?php include_once "bin/bottompart4pages.php"; ?>


</body>
</html>
