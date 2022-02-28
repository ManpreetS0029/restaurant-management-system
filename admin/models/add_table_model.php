<?php 
class AddTable{

    protected $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addTable($arrPost)
    {
        $table_data =  array(
            $arrPost["table_name"],
            $arrPost["table_capacity"],
            $_GET['id']
        );
        
        $add_table = $this->conn->prepare("insert into table_data (table_name,table_capacity,restaurant_id) values(?,?,?)");

        $add_table->execute($table_data);

        $id = $this->conn->lastInsertId();

        return $id;
    }

}


?>