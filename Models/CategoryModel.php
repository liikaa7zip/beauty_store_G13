<?php 

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getCategoryNameById($id) {
        $stmt = $this->db->query("SELECT name FROM categories WHERE id = ?", [$id]);
        return $stmt->fetchColumn();
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCategories($category_name, $category_description) {
        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($sql); // Use prepared statements
        $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
        
        return $stmt->execute(); // Returns true if successful
    }
}

?>