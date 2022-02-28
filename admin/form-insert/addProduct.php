<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_product_model.php";

$msg = "";

if(isset($_POST["add_product"]))
    {
        $msg .= productFrmValidation();

        if($msg == "1"){

            $addProduct = new AddProduct($conn);

            try{

            $addProduct->addProduct($_POST);

            $successmsg .= "Product Added Successfully";

            header("Location: ../product.php");

            

            }
            
            catch(PDOException $error)
            {
                $err .= $error->getMessage();
            }

        }

        else
        {
            header("Location: ../product.php");
        }

        

    }

?>