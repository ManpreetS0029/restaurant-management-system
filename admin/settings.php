<?php
session_start();
require_once "appcode/db_connection.php";
include_once "validation/validation.php";
require_once "models/register_model.php";
include_once "bin/currency_options.php";
include_once "bin/timezone_options.php";


$_POST = array_map('trim', $_POST);

$sql = $conn->prepare("select * from restaurant_table where restaurant_id = '".$_SESSION['user_id']."'");
$sql->execute();
$restaurant = $sql->fetchAll();

$msg = "";
$successmsg = "";

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


      <h1>Settings</h1>

          <div class="bg mt-4">

          <div class="row">
            <div class="col">

            <form method="post" class="registerForm mt-2" name="registerForm" enctype="multipart/form-data" action="form-insert/editSettings.php">


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


		<?php }

        foreach($restaurant as $rest)
        {
        ?>



		<div class="row mt-3 ">

		<div class="col-md-5">



		<label for="rest_name">Resturant Name</label><br>
			<input type="text" name="rest_name" id="rest_name" class="form-control" value="<?php echo $rest['restaurant_name']; ?>">
			<div id="rest_name_err" style="display: none;"></div>

		</div>

		<div class="col-md-5">
			<label for="restaddress">Restaurant Address</label><br>
			<input type="text" name="rest_address" id="rest_address" class="form-control" value="<?php echo $rest['restaurant_address']; ?>">
			<div id="rest_address_err" style="display: none;"></div>
		</div>

		</div>

		<div class="row mt-3 ">


		<div class="col-md-5">
			<label for="rest_contact_no">Restaurant Contact No</label><br>
			<input type="text" name="rest_contact_no" id="rest_contact_no" class="form-control" value="<?php echo $rest['restaurant_contact_no']; ?>">
			<div id="rest_contact_no_err" style="display: none;"></div>
		</div>

		<div class="col-md-5">
			<label for="rest_tagline">Restaurant Tagline</label><br>
			<input type="text" name="rest_tagline" class="form-control" value="<?php echo $rest['restaurant_tag_line']; ?>">
		</div>

		</div>


		<div class="row mt-3 ">
		<div class="col-md-5">
			<label for="timezone">Currency</label><br>

			<select name="select_currency" id="select_currency" class="form-select selectOptions custom-select">

			<option value="<?php echo $rest['restaurant_currency']; ?>"><?php echo $rest['restaurant_currency']; ?></option>



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

			<select name="select_timezone" id="select_timezone" class="form-select selectOptions custom-select">
					<option value="<?php echo $rest['restaurant_timezone']; ?>"><?php echo $rest['restaurant_timezone']; ?></option>

				<?php

					foreach ($timezoneOptions as $key => $value) {

  						echo '<option value="'.$value.'">'.$value.'</option>';

					}

				?>

			</select>

			<div id="select_timezone_err" style="display: none;"></div>
		</div>
		</div>

		<div class="row mt-3 ">
		<div class="col-md-5">
			<label for="email">Email Address</label><br>
			<input type="email" name="email" id="email" class="form-control" value="<?php echo $rest['restaurant_email']; ?>">
			<div id="email_err" style="display: none;"></div>
		</div>
        <!-- <div class="col-md-5">
            <label for="restaurant_logo">Select Logo</label>
            <input type="file" name="restaurant_logo" id="restaurant_logo" class="form-control-file" accept=".jpg,.jpeg,.png,.gif">


            </div> -->

		</div>

		<div class="row mt-3 ">
		<div class="col-md-5">

		<input type="submit" name="submit_button" id="submit_button" value="Save" class="btn btn-primary">

	</div>
</div>

<?php } ?>


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
<script type="text/javascript">
 	if (document.getElementById("regMsg").style.display = "block") {

 		registerValidation();
 	}
 </script>

</body>
</html>
