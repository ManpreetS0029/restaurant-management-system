<?php 
class AddTax{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addTax($arrPost)
    {
        $tax_data =  array(
            $arrPost["tax_name"],
            $arrPost["tax_percentage"],
            $_GET["id"]
        );
        
        $add_table = $this->conn->prepare("insert into tax_table (tax_name,tax_percentage,restaurant_id) values(?,?,?)");

        $add_table->execute($tax_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

}


?>