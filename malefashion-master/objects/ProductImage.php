<?php

class ProductImage
{
    // database connection and table name
    private string $table_name = 'product_images';
    private $conn;

    // props
    public $id;
    public $name;
    public $product_id;
    public $timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readFirst()
    {
        $query = "SELECT id, product_id, name FROM " . $this->table_name . " WHERE product_id = ? ORDER BY name DESC LIMIT 0, 1";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        // bind product id variable
        $stmt->bindParam(1, $this->product_id, PDO::PARAM_INT);
        // execute query
        $stmt->execute();

        return $stmt;
    }
}