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

    public function count()
    {
        // query to count all products
        $query = "SELECT COUNT(*) FROM " . $this->table_name;
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        // get row value
        $rows = $stmt->fetch(PDO::FETCH_NUM);

        // return count
        return $rows[0];
    }

    public function addClass(int $currentPage, int $page, string $class): string
    {
        return ($currentPage === $page) ? $class : '';
    }

    public function readByIds(array $ids)
    {
        $ids_arr = str_repeat('?,', count($ids) - 1) . '?';
//
//        // query to select products
        $query = "SELECT id, name, price FROM " . $this->table_name . " WHERE id IN ($ids_arr) ORDER BY name";
//        // prepare statement
        $stmt = $this->conn->prepare($query);
//        // execute query
        $stmt->execute($ids);
//
//        // return values from database
        return $stmt;
    }
}