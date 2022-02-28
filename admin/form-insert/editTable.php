<?php
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";

$_POST = array_map('trim', $_POST);

$msg = "";

//print_r($_POST);

if(isset($_POST["edit_table"]))
    {
        $msg .= tableFrmValidation();

        if($msg == "1"){

            $table_data =  array(
                $_POST["table_name"],
                $_POST["table_capacity"],
                $_GET["id"]
            );
    
           
            
            $edit_table = $conn->prepare("update table_data set table_name = ? , table_capacity = ? where table_id = ? ");
    
            $edit_table->execute($table_data);

            header("Location: ../table.php");

        }

        else
        {
            header("Location: ../table.php");
        }

        

    }

?>