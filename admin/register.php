<?php
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
require_once "models/register_model.php";
include_once "bin/currency_options.php";
include_once "bin/timezone_options.php";

$msg = "";

$successmsg = "";

$_POST = array_map('trim', $_POST);

if(isset($_POST['submit_button']))
{

	$msg = registerFrmValidation();

	if($msg == "1")
	{
		$register = new RegisterForm($conn);

		try
		{
			$register->addRestaurant($_POST);
			$register->addUser($_POST);
			$successmsg .= "Successfully Registered";
		}

		catch (PDOException $err)
		{
			$msg .= $err->getMessage();
		}


	}

}


?>

<?php include_once "bin/toppart.php"; ?>

<body>
<div class="container">
	<form method="post" class="registerForm mt-2" name="registerForm">

		<h1 class="text-center mt-2">Set Up Account</h1>


<div class="row">


<div class="col-md-10 offset-lg-2">

		<?php


		if($msg != "") {

			if($msg == "1")
			{

		}

		else {

			?>

		<div class="row mt-3">
			<div class="col-md-10 text-center">

				<div class="alert alert-danger" id="regMsg" style="display: block;">
					<?php echo $msg; ?>
				</div>

			</div>
		</div>


		<?php }

		}
		?>

		<?php

		if($successmsg != "" )
		{

		?>


		<div class="row mt-3">
			<div class="col-md-10 text-center">

				<div class="alert alert-success">
					<?php echo $successmsg; ?>
				</div>

			</div>
		</div>


		<?php } ?>

		<div class="row mt-3 ">

		<div class="col-md-5">

		<label for="rest_name">Resturant Name</label><br>
			<input type="text" name="rest_name" id="rest_name" class="form-control" value="<?php if(isset($_POST['rest_name'])) echo $_POST['rest_name']; ?>">
			<div id="rest_name_err" style="display: none;"></div>

		</div>

		<div class="col-md-5">
			<label for="restaddress">Restaurant Address</label><br>
			<input type="text" name="rest_address" id="rest_address" class="form-control" value="<?php if(isset($_POST['rest_address'])) echo $_POST['rest_address']; ?>">
			<div id="rest_address_err" style="display: none;"></div>
		</div>

		</div>

		<div class="row mt-3 ">


		<div class="col-md-5">
			<label for="rest_contact_no">Restaurant Contact No</label><br>
			<input type="text" name="rest_contact_no" id="rest_contact_no" class="form-control" value="<?php if(isset($_POST['rest_contact_no'])) echo $_POST['rest_contact_no']; ?>">
			<div id="rest_contact_no_err" style="display: none;"></div>
		</div>

		<div class="col-md-5">
			<label for="rest_tagline">Restaurant Tagline</label><br>
			<input type="text" name="rest_tagline" class="form-control" value="<?php if(isset($_POST['rest_tagline'])) echo $_POST['rest_tagline']; ?>">
		</div>

		</div>


		<div class="row mt-3 ">
		<div class="col-md-5">
			<label for="timezone">Currency</label><br>

			<select name="select_currency" id="select_currency" class="form-select selectOptions" value="<?php if(isset($_POST['select_currency'])) echo $_POST['select_currency']; ?>">

			<option value="select">select</option>

				<?php

					foreach ($currencyOptions as $key => $value) {

						echo '<option value="'.$value.'">'.$value.'</option>';

					}

				?>


			</select>

			<div id="select_currency_err" style="display: none;"></div>
		</div>

		<div class="col-md-5">
			<label for="timezone">Timezone</label><br>

			<select name="select_timezone" id="select_timezone" class="form-select selectOptions" value="<?php if(isset($_POST['select_timezone'])) echo $_POST['select_timezone']; ?>">
				<option value="select" >select</option>

				<?php

					foreach ($timezoneOptions as $key => $value) {

  						echo '<option value="'.$key.'">'.$value.'</option>';

					}

				?>

			</select>

			<div id="select_timezone_err" style="display: none;"></div>
		</div>
		</div>

		<div class="row mt-3 ">
		<div class="col-md-5">
			<label for="email">Email Address</label><br>
			<input type="email" name="email" id="email" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
			<div id="email_err" style="display: none;"></div>
		</div>

		<div class="col-md-5">
			<label for="password">Password</label><br>
			<input type="password" name="password" id="password" class="form-control">
			<div id="password_err" style="display: none;"></div>
		</div>
		</div>

		<div class="row mt-3 ">
		<div class="col-md-5 offset-lg-4">

		<input type="submit" name="submit_button" id="submit_button" value="Set Up" style="width:150px;" class="btn btn-primary text-center">

	</div>
</div>

</div>
</div>

	</form>

</div>

<?php include_once "bin/bottompart.php"; ?>
<script type="text/javascript">
 	if (document.getElementById("regMsg").style.display = "block") {

 		registerValidation();
 	}
 </script>

</body>
</html>
