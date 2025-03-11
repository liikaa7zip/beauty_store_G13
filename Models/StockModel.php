<?php
class ProductModel {
    private $pdo;

    function __construct() {
        $this->pdo = new Database();
    }

    public function getAllProducts() {
        $result = $this->pdo->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProducts($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $params = ['id' => $id];
        $result = $this->pdo->query($sql, $params);
        return $result->rowCount(); // Returns the number of affected rows
    }
}
?>