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
}

?>