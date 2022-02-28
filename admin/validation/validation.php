<?php

function editSettingsFrmValidation()
{
	
		$msg = "Please fill all  the required fields";

		if("" == $_POST['rest_name'])
		{
			return $msg;
		}


		if("" == $_POST["rest_address"])
		{
			return $msg;
		}



		if("" == $_POST["rest_contact_no"])
		{
			return $msg;
		}


		if("select" == $_POST["select_currency"])
		{
			return $msg;
		}


		if("select" == $_POST["select_timezone"])
		{
			return $msg;
		}



		if("" == $_POST["email"])
		{
			return $msg;
		}

		return 1;


}

function registerFrmValidation()
{

	$msg = "Please fill all  the required fields";

	if("" == $_POST['rest_name'])
	{
		return $msg;
	}


	if("" == $_POST["rest_address"])
	{
		return $msg;
	}



	if("" == $_POST["rest_contact_no"])
	{
		return $msg;
	}


	if("select" == $_POST["select_currency"])
	{
		return $msg;
	}


	if("select" == $_POST["select_timezone"])
	{
		return $msg;
	}



	if("" == $_POST["email"])
	{
		return $msg;
	}


	if("" == $_POST["password"])
	{
		return $msg;
	}


	return 1;

}

function loginFrmValidation()
{

	$msg = "Please fill all  the required fields";

	if( "" === $_POST['email'] )
	{
		return $msg;
	}

	if("" == $_POST["password"])
	{
		return $msg;
	}




	return 1;


}

function categoryFrmValidation()
{
	$msg = "Category name is required";
	if("" == $_POST["category_name"])
	{
		return $msg;
	}

	return 1;
}

function productFrmValidation()
{
	$msg = "Please fill all the required fields";
	if("select" == $_POST["category_name"])
	{
		return $msg;
	}

	if("" == $_POST["product_name"])
	{
		return $msg;
	}

	if("" == $_POST["product_price"])
	{
		return $msg;
	}

	return 1;
}

function tableFrmValidation()
{
	$msg = "Please fill all the required fields";
	if("" == $_POST["table_name"])
	{
		return $msg;
	}

	if("select" == $_POST["table_capacity"])
	{
		return $msg;
	}

	return 1;
}

function taxFrmValidation()
{
	$msg = "Please fill all the required fields";
	if("" == $_POST["tax_name"])
	{
		return $msg;
	}

	if("" == $_POST["tax_percentage"])
	{
		return $msg;
	}

	return 1;
}

function userFrmValidation()
{
	$msg = "Please fill all the required fields";
	if("" == $_POST["user_name"])
	{
		return $msg;
	}

	if("" == $_POST["user_contact_no"])
	{
		return $msg;
	}

	if("" == $_POST["user_email"])
	{
		return $msg;
	}

	if("" == $_POST["user_password"])
	{
		return $msg;
	}


	return 1;
}

function orderFrmValidation()
{
	$msg = "Please fill all the required fields";
	if("" == $_POST["category_name"])
	{
		return $msg;
	}

	if("" == $_POST["item_quantity"])
	{
		return $msg;
	}

	return 1;
}

?>
