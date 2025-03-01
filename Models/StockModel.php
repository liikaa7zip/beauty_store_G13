<?php
class ProductModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }
    public function getAllProducts()
    {
        $result = $this->pdo->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}