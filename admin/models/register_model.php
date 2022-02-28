<?php
class RegisterForm
{
	protected $conn;

	 public function __construct($conn)
	 {
	 	$this->conn = $conn;
	 }

	 public function addRestaurant($arrPost)
	 {

	 	$register_data = array(
	 		$arrPost['rest_name'],
	 		$arrPost['rest_tagline'],
	 		$arrPost['rest_address'],
	 		$arrPost['rest_contact_no'],
	 		$arrPost['email'],
	 		$arrPost['select_currency'],
	 		$arrPost['select_timezone']

	 	);


	 	$register = $this->conn->prepare("insert into restaurant_table (restaurant_name,restaurant_tag_line,restaurant_address,restaurant_contact_no,restaurant_email,restaurant_currency,restaurant_timezone) values(?,?,?,?,?,?,?)");

	 	$register->execute($register_data);

	 	$id = $this->conn->lastInsertId();

	 	return $id;


	 }


	 public function addUser($arrPost)
	 {

		$restaurant_table = $this->conn->prepare("select * from restaurant_table");
		$last_id =  $this->conn->lastInsertId('restaurant_id');	

		
		
		$user_data = array(
	 		substr($arrPost['email'],0,strpos($arrPost['email'], '@')),
	 		$arrPost['rest_contact_no'],
	 		$arrPost['email'],
	 		md5($arrPost['password']),
			date('Y-m-d H:i:s'),
			$last_id
			

	 	);

		 
	 	$user = $this->conn->prepare("insert into user_table (user_name,user_contact_no,user_email,user_password,user_created_on,restaurant_id) values(?,?,?,?,?,?)");

	 	$user->execute($user_data);

	 	$id = $this->conn->lastInsertId();

	 	return $id;
	 }
	}
	


?>