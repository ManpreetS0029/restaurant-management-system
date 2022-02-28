<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_category_model.php";

$msg = "";

if(isset($_POST["add_category"]))
    {
        $msg .= categoryFrmValidation();

        if($msg == "1"){

            $addCategory = new AddCategory($conn);

            try{

            $addCategory->addCategory($_POST);

            $successmsg .= "Category Added Successfully";

            header("Location: ../category.php");

            

            }
            
            catch(PDOException $error)
            {
                $err .= $error->getMessage();
            }

        }

        else
        {
            header("Location: ../category.php");
        }

        

    }

?>