<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProducts($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->query($sql, $params);
    }

    public function createProduct($name, $stocks, $category_id, $status) {
        $sql = "INSERT INTO products (name, stocks, category_id, status) VALUES (:name, :stocks, :category_id, :status)";
        $params = [
            ':name' => $name,
            ':stocks' => $stocks,
            ':category_id' => $category_id,
            ':status' => $status
        ];
        return $this->db->query($sql, $params);
    }
}
?>
