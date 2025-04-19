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

    public function storeProduct($data) {
        // Remove the dollar sign if it exists
        $price = str_replace('$', '', $data['price']);
        
        $sql = "INSERT INTO products (name, description, price, original_price, category_id, stocks, status, image) 
                VALUES (:name, :description, :price, :origin_price, :category_id, :stocks, :status, :image)";
        
        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => (float)$price,  
            ':original_price' => $data['origin_price'], 
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status'],
            ':image' => isset($data['image']) ? $data['image'] : ''
        ];

        // Log the query and parameters for debugging
        error_log("SQL Query: $sql");
        error_log("SQL Params: " . json_encode($params));

        return $this->db->query($sql, $params);
    }

    public function updateProduct($id, $data)
    {
        $sql = "UPDATE products 
                SET name = COALESCE(:name, name), 
                    description = COALESCE(:description, description), 
                    price = COALESCE(:price, price), 
                    original_price = COALESCE(:original_price, original_price), 
                    category_id = COALESCE(:category_id, category_id), 
                    stocks = :stocks, 
                    status = COALESCE(:status, status), 
                    image = COALESCE(:image, image) 
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':name' => $data['name'] ?? null,
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'] ?? null,
            ':original_price' => $data['original_price'] ?? null,
            ':category_id' => $data['category_id'] ?? null,
            ':stocks' => $data['stocks'], // Ensure stocks is updated
            ':status' => $data['status'] ?? null,
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
        $sql = "INSERT INTO products (name, description, price, original_price, category_id, stocks, status, image) 
                VALUES (:name, :description, :price, :original_price, :category_id, :stocks, :status, :image)";

        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':original_price' => $data['original_price'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
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
