<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_tax_model.php";

$msg = "";

if(isset($_POST["add_tax"]))
    {
        $msg .= taxFrmValidation();

        if($msg == "1"){

            $addProduct = new AddTax($conn);

            try{

            $addProduct->addTax($_POST);

            $successmsg .= "Table Added Successfully";

            header("Location: ../tax.php");

            

            }
            
            catch(PDOException $error)
            {
                $err .= $error->getMessage();
            }

        }

        else
        {
            header("Location: ../tax.php");
        }

        

    }

?>