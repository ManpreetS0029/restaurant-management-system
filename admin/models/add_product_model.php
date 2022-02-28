<?php 
class AddProduct{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addProduct($arrPost)
    {
        $product_data =  array(
            $arrPost["category_name"],
            $arrPost["product_name"],
            $arrPost["product_price"],
            $_GET['id']
        );
        
        $add_product = $this->conn->prepare("insert into product_table (category_name,product_name,product_price,restaurant_id) values(?,?,?,?)");

        $add_product->execute($product_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

}


?>