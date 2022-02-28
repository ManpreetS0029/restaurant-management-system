<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";

$_POST = array_map('trim', $_POST);

$msg = "";

//print_r($_POST);

if(isset($_POST["edit_category"]))
    {
        $msg .= orderFrmValidation();

        if($msg == "1"){

            $order_data =  array(
                $_POST["category_name"],
                $_POST["item_quantity"],
                $_POST["item_name"],
                $_GET['id']
            );  
    
           
            
            $edit_category = $conn->prepare("update order_item_table set category_name = ? , product_quantity = ? , product_name = ? where id = ? ");
    
            $edit_category->execute($order_data);

            header("Location: ../add_order.php?tbl_name=".$_GET["tbl_name"]);

        }

        else
        {
            header("Location: ../add_order.php?tbl_name=".$_GET["tbl_name"]);
        }

        

    }

?>