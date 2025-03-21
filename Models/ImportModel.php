<?php
class ImportModel {
    private $db;

    public function __construct() {
        // Initialize the database connection
        $this->db = (new Database())->getConnection(); // Adjust based on your DB setup
    }

    /**
     * Fetch all products from the database
     * @return array Array of product records
     */
    public function getAllProducts() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM products");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error in getAllProducts: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Insert or update a product in the database
     * @param array $productData Array containing product details (name, stocks, category_id, status)
     * @return bool True on success, false on failure
     */
    public function insertOrUpdateProduct($productData) {
        try {
            $stmt = $this->db->prepare("INSERT INTO products (name, stocks, category_id, status) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE stocks = ?, category_id = ?, status = ?");
            $stmt->execute([
                $productData['name'],
                $productData['stocks'],
                $productData['category_id'],
                $productData['status'],
                $productData['stocks'],
                $productData['category_id'],
                $productData['status']
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error in insertOrUpdateProduct: " . $e->getMessage());
            return false;
        }
    }
}
?>
