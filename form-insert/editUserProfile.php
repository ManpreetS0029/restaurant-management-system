<?php
session_start();
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
$_POST = array_map('trim', $_POST);

$msg = "";


if(isset($_POST["edit_user"]))
    {
        //upload file code
        $targetDir = "admin/uploads/dp/";
        $fileName = basename($_FILES["user_profile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        $allowedTypes = array("jpg","jpeg","png","gif");
        $fileSize = $_FILES["user_profile"]["size"];

        $msg .= userFormValidation();

        if($msg == "1"){

            $user_data =  array(
                $_POST["user_email"],
                md5($_POST["user_password"]),
                $_POST["user_contact_no"],
                $_SESSION["user_id"]

            );

            $edit_user = $conn->prepare("update user_table set user_email = ?,user_password = ?,user_contact_no = ? where user_id = ?");

            $edit_user->execute($user_data);

            if(!empty($_FILES["user_profile"]["name"]))
            {

                if(in_array($fileType,$allowedTypes))
                {

                    if($fileSize <= 1000000)
                    {

                    if(move_uploaded_file($_FILES["user_profile"]["tmp_name"],$targetFilePath))
                    {

                    try{

                        $user_data =  array(
                            $fileName,
                            $_SESSION["user_id"]

                        );

                        $imgToDb = $conn->prepare("update user_table set user_profile = ? where user_id = ?");

                        $imgToDb->execute($user_data);

                        $successmsg .= "User Added Successfully";

                        header("Location: ../user-profile.php");

                        }

                        catch(PDOException $error)
                        {
                            echo $err .= $error->getMessage();
                        }
                }
            }

            }


        }

        else
        {
            try{

                $user_data =  array(
                    "",
                    $_SESSION["user_id"]

                );

                $noImgToDb = $conn->prepare("update user_table set user_profile = ? where user_id = ?");

                $noImgToDb->execute($user_data);

                $successmsg .= "User Added Successfully";

                header("Location: ../user-profile.php");

                }

                catch(PDOException $error)
                {
                    echo $err .= $error->getMessage();
                }
        }
    }
}



?>
