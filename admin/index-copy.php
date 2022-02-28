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

<?php include_once "bin/toppart.php"; ?>

<body>
<div class="container">
	<form method="post" class="loginForm mt-2" name="loginForm">

		<h1 class="text-center mt-2">Restaurant Management <br/> System</h1>

<?php



if($msg != "") {

	if($msg == "1")
	{

}

else {

		?>


<div class="row mt-3">
			<div class="col-md-6 offset-lg-3 text-center">

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


<div class="row mt-3">
			<div class="col-md-6 offset-lg-3 text-center">

				<div class="alert alert-danger" id="errMsg">
					<?php echo $err;


					?>
				</div>

			</div>
		</div>


		<?php } ?>



<div class="row">


<div class="col-md-6 offset-lg-4">
		<div class="row mt-3 ">
		<div class="col-md-8">
			<label for="email">Email Address</label><br>
			<input type="email" name="email" id="email" class="form-control" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>">
			<div id="email_err" style="display: none;"></div>
		</div>
		</div>

		<div class="row mt-3 ">
		<div class="col-md-8">
			<label for="password">Password</label><br>
			<input type="password" name="password" id="password" class="form-control" value="<?php //if (isset($_POST["password"])) echo $_POST["password"]; ?>">
			<div id="password_err" style="display: none;">
		</div>


		</div>

		<div class="row mt-3 ">
		<div class="col-md-5 ">


		<input type="submit" name="submit_button" id="login_button" value="Login" class="btn btn-primary">





	</div>
</div>

</div>
</div>

	</form>

</div>

 <?php include_once "bin/bottompart.php"; ?>
 <script type="text/javascript">
 	if (document.getElementById("loginMsg").style.display = "block") {

 		loginValidation();


 	}




 </script>

</body>
</html>
