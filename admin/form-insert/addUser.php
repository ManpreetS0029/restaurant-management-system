<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_user_model.php";
$_POST = array_map('trim', $_POST);

$msg = "";


if(isset($_POST["add_user"]))
    {
        //upload file code
        $targetDir = "../uploads/dp/";
        $fileName = basename($_FILES["user_profile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowedTypes = array("jpg","jpeg","png","gif");
        $fileSize = $_FILES["user_profile"]["size"];

        $msg .= userFrmValidation();

        if($msg == "1"){

            $addUser = new AddUser($conn);

            if(!empty($_FILES["user_profile"]["name"]))
            {

                if(in_array($fileType,$allowedTypes))
                {

                    if($fileSize <= 1000000)
                    {

                    if(move_uploaded_file($_FILES["user_profile"]["tmp_name"],$targetFilePath))
                    {

                    try{

                        $addUser->addUser($_POST,$fileName);
            
                        $successmsg .= "User Added Successfully";
            
                        header("Location: ../user.php");
            
                        }
                        
                        catch(PDOException $error)
                        {
                            $err .= $error->getMessage();
                        }
                } 
            }
           
            }
              
           
        }

        else
        {
            try{

                $addUser->addUser($_POST,"");
    
                $successmsg .= "User Added Successfully";
    
                header("Location: ../user.php");
    
                }
                
                catch(PDOException $error)
                {
                    $err .= $error->getMessage();
                }
        }
    }
}

 

?>