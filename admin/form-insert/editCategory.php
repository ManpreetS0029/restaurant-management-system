<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";

$_POST = array_map('trim', $_POST);

$msg = "";

//print_r($_POST);

if(isset($_POST["edit_category"]))
    {
        $msg .= categoryFrmValidation();

        if($msg == "1"){

            $category_data =  array(
                $_POST["category_name"],
                $_GET['id']
            );  
    
           
            
            $edit_category = $conn->prepare("update product_category_table set category_name = ? where category_id = ? ");
    
            $edit_category->execute($category_data);

            header("Location: ../category.php");

        }

        else
        {
            header("Location: ../category.php");
        }

        

    }

?>