<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";

$_POST = array_map('trim', $_POST);

$msg = "";

//print_r($_POST);

if(isset($_POST["edit_tax"]))
    {
        $msg .= taxFrmValidation();

        if($msg == "1"){

            $tax_data =  array(
                $_POST["tax_name"],
                $_POST["tax_percentage"],
                $_GET["id"]
            );
    
           
            
            $edit_tax = $conn->prepare("update tax_table set tax_name = ? , tax_percentage = ? where tax_id  = ? ");
    
            $edit_tax->execute($tax_data);

            header("Location: ../tax.php");

        }

        else
        {
            header("Location: ../tax.php");
        }

        

    }

?>