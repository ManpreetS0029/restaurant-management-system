<?php
require_once "appcode/db_connection.php";

if(isset($_POST["category"]))
{
    $itemName = $_POST["category"];
    $sql = $conn->prepare("select * from product_table where category_name = ?");
    $sql->execute(array($itemName));
    $rows = $sql->fetchAll();

    if($itemName !== 'Select'){
        echo " <label for='item_name'>Item Name</label>";
        echo "<select class='custom-select' name='item_name'>";
        foreach($rows as $row)
        {  
                echo "<option>".$row["product_name"]."</option>";
                
        }
        echo "</select>";
    } 
}


?>