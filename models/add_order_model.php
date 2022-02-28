<?php 
class AddOrder{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addOrderItem($arrPost)
    {
        $sql = $this->conn->prepare("select * from product_table where product_name = ?");
        $sql->execute(array($arrPost["item_name"]));
        $getProdData = $sql->fetch();
        $prodPrice = $getProdData["product_price"];
        $orderId = ltrim($_GET["tbl_name"],"Table");

        

        $order_item_data =  array(
            $orderId,
            $arrPost["item_name"],
            $arrPost["item_quantity"],
            $prodPrice,
            $arrPost["item_quantity"] * $prodPrice,
            $_GET["id"]


        );
        
        $add_order_item = $this->conn->prepare("insert into order_item_table (order_id,product_name,product_quantity,product_rate,product_amount,restaurant_id) values(?,?,?,?,?,?)");

        $add_order_item->execute($order_item_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

    public function addOrder($arrPost)
    {
        $id = $_GET["user_id"];
        $restaurant_id = $_GET["id"];

        $query = $this->conn->prepare("select * from user_table where user_id = '$id' and restaurant_id = '$restaurant_id'");
        $query->execute();
        $getUserData = $query->fetchAll();

        $sum_of_column = $this->conn->prepare("select sum(product_amount) as prod_amount from order_item_table ");
        $sum_of_column->execute();
        $sum = $sum_of_column->fetch(PDO::FETCH_ASSOC);
        
        foreach($getUserData as $user)
        {

        $characters = "abcdefghijklmnopqrstuvwxyz";
        $charactersLen = strlen($characters);
        $length = 4;
        $randomString = "";

        for($i=0;$i<$length;$i++)
        {
            $randomString .= $characters[rand(0,$charactersLen - 1)];
        }

        $order_number = $randomString.ltrim($_GET["tbl_name"],"Table ");

        $order_item_data =  array(
            $order_number,
            $_GET["tbl_name"],
            $sum["prod_amount"],
            date("Y-m-d"),
            date("h:i:sa"),
            $user["user_name"],
            $user["restaurant_id"]
            


        );
        
        $add_order_item = $this->conn->prepare("insert into order_table (order_number,order_table,order_gross_amount,order_date,order_time,order_waiter,restaurant_id) values(?,?,?,?,?,?,?)");

        $add_order_item->execute($order_item_data);

        $id = $this->conn->lastInsertId();

        return $id;

    }
    }

    

    

}


?>