<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";

$_POST = array_map('trim', $_POST);

$msg = "";

//print_r($_POST);

if(isset($_POST["edit_product"]))
    {
        $msg .= productFrmValidation();

        if($msg == "1"){

            $product_data =  array(
                $_POST["category_name"],
                $_POST["product_name"],
                $_POST["product_price"],
                $_GET["id"]
            );
    
           
            
            $edit_product = $conn->prepare("update product_table set category_name = ? , product_name = ? , product_price = ? where product_id = ? ");
    
            $edit_product->execute($product_data);

            header("Location: ../product.php");

        }

        else
        {
            header("Location: ../product.php");
        }

        

    }

?>