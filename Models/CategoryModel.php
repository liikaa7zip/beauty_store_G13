<?php

class CategoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id)
    {
        $stmt = $this->db->query("SELECT * FROM categories WHERE id = ?", [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategoryNameById($id)
    {
        $stmt = $this->db->query("SELECT name FROM categories WHERE id = ?", [$id]);
        return $stmt->fetchColumn();
    }

    public function createCategories($category_name, $category_description)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
            $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation
                echo "Error: Duplicate entry for category name.";
            } else {
                echo "Error: " . $e->getMessage();
            }
            return false;
        }
    }

    public function updateCategory($id, $category_name, $category_description)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $category_description, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteCategoryById($categoryId)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $categoryId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
