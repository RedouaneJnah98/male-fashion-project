<?php

class Database
{
    // database credentials using PDO approach
    private string $host = 'localhost';
    private string $username = 'root';
    private string $db_name = 'shopp_cart_session';
    private string $password = '';
    public $conn;

    public function connect(): ?PDO
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo 'Connection error:' . $exception->getMessage();
        }

        return $this->conn;
    }
}