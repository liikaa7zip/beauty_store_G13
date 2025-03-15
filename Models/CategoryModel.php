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
}

?>