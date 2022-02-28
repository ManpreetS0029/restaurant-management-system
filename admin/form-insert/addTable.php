<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_table_model.php";

$msg = "";

if(isset($_POST["add_table"]))
    {
        $msg .= tableFrmValidation();

        if($msg == "1"){

            $addProduct = new AddTable($conn);

            try{

            $addProduct->addTable($_POST);

            $successmsg .= "Table Added Successfully";

            header("Location: ../table.php");

            

            }
            
            catch(PDOException $error)
            {
                $err .= $error->getMessage();
            }

        }

        else
        {
            header("Location: ../table.php");
        }

        

    }

?>