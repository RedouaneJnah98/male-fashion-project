<?php

class Product
{
    // database connection and table name
    private string $table_name = 'products';
    private $conn;

    // props
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $category_name;
    public $timestamp;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read($from_record_num, $records_per_page)
    {
        // get all products from database
        $query = "SELECT id, name, description, price FROM " . $this->table_name . " ORDER BY created DESC LIMIT ?, ?";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // bind params
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();
        // return
        return $stmt;
    }
}