<?php
class AddCategory{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addCategory($arrPost)
    {
        $category_data =  array(
            $arrPost["category_name"],
            $_GET["id"]

        );

        $add_category = $this->conn->prepare("insert into product_category_table (category_name,restaurant_id) values(?,?)");

        $add_category->execute($category_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

}


?>
