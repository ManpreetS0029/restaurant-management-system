<?php
session_start();
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
include_once "../bin/currency_options.php";
include_once "../bin/timezone_options.php";

$msg = "";

$successmsg = "";

$_POST = array_map('trim', $_POST);

if(isset($_POST['submit_button']))
{

	$msg = editSettingsFrmValidation();

	if($msg == "1")
	{

		try
		{

    	$register = $conn->prepare("update restaurant_table set restaurant_name =? , restaurant_tag_line = ? , restaurant_address = ? , restaurant_contact_no = ? , restaurant_email = ? , restaurant_currency = ? , restaurant_timezone = ? where restaurant_id = ?");

  	 	$register->execute(array($_POST['rest_name'],$_POST['rest_tagline'],$_POST['rest_address'],$_POST['rest_contact_no'],$_POST['email'],$_POST['select_currency'],$_POST['select_timezone'],$_SESSION['user_id']));


  	 	$user = $conn->prepare("update user_table set user_email = ? , user_contact_no = ? , restaurant_id = ? where user_id = ?");

  	 	$user->execute(array($_POST['email'],$_POST['rest_contact_no'],$_SESSION['user_id'],$_SESSION['user_id']));

			$successmsg .= "Successfully Updated";
      header("Location: ../settings.php");
		}

		catch (PDOException $err)
		{
			$msg .= $err->getMessage();
		}


	}

}


?>
