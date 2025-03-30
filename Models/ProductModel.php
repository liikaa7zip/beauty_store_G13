<?php
class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProductsByCategoryName($category_name = null)
    {
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

    // Method to get products by category
    public function getProductsByCategory($category_id)
    {
        $sql = "SELECT products.*, categories.name AS category_name 
                FROM products 
                LEFT JOIN categories ON products.category_id = categories.id 
                WHERE products.category_id = ?";
        return $this->db->query($sql, [$category_id])->fetchAll();
    }

    public function getAllProducts()
    {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductByID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeProduct($data)
    {
        $sql = "INSERT INTO products (name, description, price, expire_date, category_id, stocks, start_date, status, image) 
                VALUES (:name, :description, :price, :expire_date, :category_id, :stocks, :start_date, :status, :image)";

        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':expire_date' => $data['expire_date'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':start_date' => $data['start_date'],
            ':status' => $data['status'],
            ':image' => $data['image']
        ];

        return $this->db->query($sql, $params);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE products 
        SET name = :name, 
            description = :description, 
            price = :price, 
            expire_date = :expire_date, 
            category_id = :category_id, 
            stocks = :stocks, 
            status = :status, 
            start_date = :start_date, 
            image = :image 
        WHERE id = :id";

        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':expire_date' => $data['expire_date'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':start_date' => $data['start_date'],
            ':image' => $data['image']
        ];

        try {
            error_log("Update Query: $sql");
            error_log("Update Params: " . json_encode($params));
            $this->db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            error_log("Database Update Error: " . $e->getMessage());
            return false;
        }

        // Check if stock is being reduced to low levels (threshold = 5)
        if ($data['stocks'] <= 5 && $currentProduct['stocks'] > 5) {
            $this->createLowStockNotification($data['name'], $data['stocks']);
        }

        return $this->db->query($sql, $params);
    }

    private function createLowStockNotification($productName, $stocks)
    {
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

    public function getLowStockProducts($threshold = 5)
    {
        $sql = "SELECT * FROM products WHERE stocks <= ?";
        return $this->db->query($sql, [$threshold])->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function deleteProduct($id)
    {
        $stmt = $this->db->query("DELETE FROM products WHERE id = :id", [':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function deleteProducts($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->query($sql, $params);
    }

    public function createProduct($data)
    {
        $sql = "INSERT INTO products (name, description, price, expire_date, category_id, stocks, start_date, status, image) 
                VALUES (:name, :description, :price, :expire_date, :category_id, :stocks, :start_date, :status, :image)";

        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':expire_date' => $data['expire_date'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':start_date' => $data['start_date'],
            ':status' => $data['status'],
            ':image' => $data['image']
        ];

        try {
            $this->db->query($sql, $params);
            return true;
        } catch (Exception $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            return false;
        }
    }
    public function getProductsByCategoryId($categoryId)
    {
        $sql = "SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ?";
        return $this->db->query($sql, [$categoryId])->fetchAll();
    }
}
