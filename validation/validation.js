function registerValidation()
{

var rest_name = document.getElementById("rest_name").value;	
var rest_address = document.getElementById("rest_address").value;	
var rest_contact_no = document.getElementById("rest_contact_no").value;	
var select_currency = document.getElementById("select_currency").value;	
var select_timezone = document.getElementById("select_timezone").value;	
var email = document.getElementById("email").value;	
var password = document.getElementById("password").value;	

if(rest_name == "" || rest_name == null)
{
	document.getElementById("rest_name_err").innerHTML = "Name is required";
	document.getElementById("rest_name_err").style.display = "block";
}
	

if(rest_address == "" || rest_address == null)
{
	document.getElementById("rest_address_err").innerHTML = "Address is required";
	document.getElementById("rest_address_err").style.display = "block";
}
if(rest_contact_no == "" || rest_contact_no == null)
{
	document.getElementById("rest_contact_no_err").innerHTML = "Contact no is required";
	document.getElementById("rest_contact_no_err").style.display = "block";
}
if(select_currency == "select")
{
	document.getElementById("select_currency_err").innerHTML = "Currency is required";
	document.getElementById("select_currency_err").style.display = "block";
}
if(select_timezone == "select")
{
	document.getElementById("select_timezone_err").innerHTML = "Timezone is required";
	document.getElementById("select_timezone_err").style.display = "block";
}
if(email == "" || email == null)
{
	document.getElementById("email_err").innerHTML = "Email is required";
	document.getElementById("email_err").style.display = "block";
}
if(password == "" || password == null)
{
	document.getElementById("password_err").innerHTML = "Password is required";
	document.getElementById("password_err").style.display = "block";
}
	return false;
}

	





function loginValidation()
{
	

	var email = document.getElementById("email").value;	
	var password = document.getElementById("password").value;




	if(email == "" || email == null){

	document.getElementById("email_err").innerHTML = "Email is required";
	document.getElementById("email_err").style.display = "block";
	document.getElementById("loginMsg").style.display = "block";
	
	}

	if(password == "" || password == null){

	document.getElementById("password_err").innerHTML = "Password is required";
	document.getElementById("password_err").style.display = "block";

	}

	

	return false;
}

	

