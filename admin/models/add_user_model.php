<?php 
class AddUser{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addUser($arrPost, $file="")
    {
        $user_data =  array(
            $arrPost["user_name"],
            $arrPost["user_contact_no"],
            $arrPost["user_email"],
            md5($arrPost["user_password"]),
            $file,
            $arrPost["user_type"],
            date('Y-m-d H:i:s'),
            $_GET['id']

        );
        
        $add_user = $this->conn->prepare("insert into user_table (user_name,user_contact_no,user_email,user_password,user_profile,user_type,user_created_on,restaurant_id) values(?,?,?,?,?,?,?,?)");

        $add_user->execute($user_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

}


?>