<?php

class ProductImage
{
    // database connection and table name
    private string $table_name = 'products';
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
}