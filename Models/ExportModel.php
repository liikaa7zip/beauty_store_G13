<?php

class ExportModel {
    private $db;

    public function __construct() {
        // Initialize the database connection
        $this->db = (new Database())->getConnection(); // Adjust based on your DB setup
    }

    public function getAllProducts() {
        // Placeholder method to fetch all products
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function storeProduct($productData) {
        try {
            // Assuming this is a PDO-based method
            $stmt = $this->db->prepare("INSERT INTO products (name, description, price, category_id, stocks, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $productData['name'],
                $productData['description'],
                $productData['price'],
                $productData['category_id'],
                $productData['stocks'],
                $productData['status']
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}
?>
