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

    public function getProductByID($id) {
        $stmt = $this->db->query("SELECT * FROM products WHERE id = :id", [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeProduct($data) {
        // Remove the dollar sign if it exists
        $price = str_replace('$', '', $data['price']);
        
        $sql = "INSERT INTO products (name, description, price, category_id, stocks, status, image) 
                VALUES (:name, :description, :price, :category_id, :stocks, :status, :image)";
        
        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => (float)$price,  // Store as decimal without $
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':image' => isset($data['image']) ? $data['image'] : ''
        ];
        
        return $this->db->query($sql, $params);
    }
    
    

    public function updateProduct($id, $data) {
        $sql = "UPDATE products 
                SET name = :name, description = :description, price = :price, category_id = :category_id, 
                    stocks = :stocks, status = :status 
                WHERE id = :id";

        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':id' => $id
        ];

        return $this->db->query($sql, $params);
    }

    public function deleteProduct($id) {
        $stmt = $this->db->query("DELETE FROM products WHERE id = :id", [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function deleteProducts($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->query($sql, $params);
    }

    public function createProduct($data) {
        $sql = "INSERT INTO products (name, description, price, category_id, stocks, status, image) 
                VALUES (:name, :description, :price, :category_id, :stocks, :status, :image)";
        $params = [
            ':name' => $data['name'],
            ':description' => isset($data['description']) ? $data['description'] : null,  // Optional, can be NULL
            ':price' => $data['price'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':image' => isset($data['image']) ? $data['image'] : null // Optional, can be NULL
        ];
        return $this->db->query($sql, $params);
    }
    
}
?>
