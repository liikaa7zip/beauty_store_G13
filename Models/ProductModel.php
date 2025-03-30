<?php
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getProductsByCategoryName($category_name = null) {
        if ($category_name) {
            $stmt = $this->db->prepare("SELECT * FROM products 
                WHERE category_id = (SELECT id FROM categories WHERE name = ? LIMIT 1)");
            $stmt->execute([$category_name]);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM products");
            $stmt->execute();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($category_id) {
        $sql = "SELECT products.*, categories.name AS category_name 
                FROM products 
                LEFT JOIN categories ON products.category_id = categories.id 
                WHERE products.category_id = ?";
        return $this->db->query($sql, [$category_id])->fetchAll();
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
            ':price' => (float)$price,
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':image' => isset($data['image']) ? $data['image'] : ''
        ];
        
        return $this->db->query($sql, $params);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE products 
                SET name = COALESCE(:name, name), 
                    description = COALESCE(:description, description), 
                    price = COALESCE(:price, price), 
                    expire_date = COALESCE(:expire_date, expire_date), 
                    category_id = COALESCE(:category_id, category_id), 
                    stocks = :stocks, 
                    status = COALESCE(:status, status), 
                    start_date = COALESCE(:start_date, start_date), 
                    image = COALESCE(:image, image) 
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':name' => $data['name'] ?? null,
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'] ?? null,
            ':expire_date' => $data['expire_date'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':stocks' => $data['stocks'], // Ensure stocks is updated
            ':status' => $data['status'] ?? null,
            ':start_date' => $data['start_date'] ?? null,
            ':image' => $data['image'] ?? null
        ];

        try {
            // Log the query and parameters for debugging
            error_log("Update Query: $sql");
            error_log("Update Params: " . json_encode($params));

            $this->db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            error_log("Database Update Error: " . $e->getMessage());
            return false;
        }
    }


    private function createLowStockNotification($productName, $stocks) {
        $message = "The product '$productName' is running low with only $stocks items left in stock.";
        
        $sql = "INSERT INTO store_notifications 
                (notification_title, notification_message, notification_type, start_date, end_date, status) 
                VALUES (:title, :message, :type, :start_date, :end_date, :status)";
        
        $params = [
            ':title' => "Low Stock Alert: $productName",
            ':message' => $message,
            ':type' => 'low_stock',
            ':start_date' => date('Y-m-d H:i:s'),
            ':end_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
            ':status' => 'active'
        ];

        return $this->db->query($sql, $params);
    }

    public function getLowStockProducts($threshold = 5) {
        $sql = "SELECT * FROM products WHERE stocks <= ?";
        return $this->db->query($sql, [$threshold])->fetchAll(PDO::FETCH_ASSOC);
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
            ':description' => isset($data['description']) ? $data['description'] : null,
            ':price' => $data['price'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':image' => isset($data['image']) ? $data['image'] : null
        ];
        return $this->db->query($sql, $params);
    }
}