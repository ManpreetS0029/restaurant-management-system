<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_order_model.php";



if(isset($_POST["add_order"]))
{
  
  $msg = orderFrmValidation();

  if($msg == "1")
  {
    $addOrder = new AddOrder($conn);

    try
    {  
      $addOrder->addOrderItem($_POST);
      $sql = $conn->prepare("select * from order_item_table where order_id = ?");
      $sql->execute(array(trim($_GET["tbl_name"],"Table ")));

      if($sql->rowCount() == 1)
      {
      
        $addOrder->addOrder($_POST);
        header("Location: ../add_order.php?id=".$restaurant_id."&tbl_name=".$_GET["tbl_name"]);
      }
      else if($sql->rowCount() > 1)
      {
        $query = $conn->prepare("select sum(product_amount) as prod_amount from order_item_table where order_id = ?");
        $query->execute(array(trim($_GET["tbl_name"],"Table ")));
        $getOrderItems = $query->fetch(PDO::FETCH_ASSOC);
       
        $grossItemPrice = $getOrderItems["prod_amount"];  
        $updateOrderTable = $conn->prepare("update order_table set order_gross_amount = ? where order_table = ? ");
        $updateOrderTable->execute(array($grossItemPrice,$_GET["tbl_name"]));
        header("Location: ../add_order.php?id=".$restaurant_id."&tbl_name=".$_GET["tbl_name"]);
        

      }

    }
    catch(PDOException $error)
    {
      $err = $error->getMessage();
      echo $err;
    }
  }
  else
  {
    header("Location: ../add_order.php");
  }

}

?>