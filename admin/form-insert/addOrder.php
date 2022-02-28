<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require_once "../appcode/db_connection.php";
include_once "../validation/validation.php";
require_once "../models/add_order_model.php";

$getUserName = $conn->prepare("select * from user_table where user_id = ?");
$getUserName->execute(array($_SESSION["user_id"]));
$user_type = $getUserName->fetchAll();

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
        foreach($user_type as $usr)
        {

        $addOrder->addOrder($_POST,$usr['user_type']);
        header("Location: ../add_order.php?id=".$restaurant_id."&tbl_name=".$_GET["tbl_name"]);

        }
      }
      else if($sql->rowCount() > 1)
      {
        $query = $conn->prepare("select sum(product_amount) as prod_amount from order_item_table where order_id = ?");
        $query->execute(array(trim($_GET["tbl_name"],"Table ")));
        $getOrderItems = $query->fetch(PDO::FETCH_ASSOC);

        $grossItemPrice = $getOrderItems["prod_amount"];
        $updateOrderTable = $conn->prepare("update order_table set order_gross_amount = ? where order_table = ? and order_status != 'Completed'");
        $updateOrderTable->execute(array($grossItemPrice,$_GET["tbl_name"]));
        header("Location: ../add_order.php?id=".$restaurant_id."&tbl_name=".$_GET["tbl_name"]);

        $sum_of_tax = $conn->prepare("select sum(tax_percentage) as tax from tax_table");
        $sum_of_tax->execute();
        $tax = $sum_of_tax->fetch(PDO::FETCH_ASSOC);

        $order_tax_amount = ($getOrderItems["prod_amount"] * $tax["tax"]) / 100;
        $order_net_amount = $getOrderItems["prod_amount"] + $order_tax_amount ;
        
       
        $update_order = $conn->prepare("update order_table set order_tax_amount = ? , order_net_amount = ? where order_table = ? and order_status != 'Completed'");
        $update_order->execute(array($order_tax_amount,$order_net_amount,$_GET["tbl_name"]));

        $select_ord_tx_amt = $conn->prepare("select sum(order_tax_amount) as amt from order_table where order_table = ? ");
        $select_ord_tx_amt->execute(array($_GET["tbl_name"]));
        $order_tax_amount = $select_ord_tx_amt->fetch(PDO::FETCH_ASSOC);

        $tax_amt = $order_tax_amount["amt"] / 2;


        $update_ord_tx_tbl = $conn->prepare("update order_tax_table set order_tax_amount = ? where order_id = ?");
        $update_ord_tx_tbl->execute(array($tax_amt,ltrim($_GET["tbl_name"],"Table ")));

        

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
