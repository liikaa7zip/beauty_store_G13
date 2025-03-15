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

<<<<<<< HEAD
<<<<<<< HEAD
=======

=======
>>>>>>> d594a2d (fix(Display stock page):fix style form login and products page [BEATU-149])
    public function getProductByID($id) {
        $stmt = $this->db->query("SELECT * FROM products WHERE id = :id", [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeProduct($data) {
        $sql = "INSERT INTO products (name, description, price, category_id, stocks, status) 
                VALUES (:name, :description, :price, :category_id, :stocks, :status)";
        
        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':category_id' => $data['category_id'],
            ':stocks' => $data['stocks'],
            ':status' => $data['status']
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

>>>>>>> 22f8fc0 (style(edit products):display edit form [BEATU-157])
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
