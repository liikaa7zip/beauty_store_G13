<?php

class PromotionModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    // Get all promotions from the database
    public function getAllPromotions()
    {
        $stmt = $this->pdo->query("SELECT * FROM promotions ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Create a new promotion in the database
    public function createPromotion($data)
    {
        try {
            $stmt = $this->pdo->query(
                "INSERT INTO promotions (promotion_name, promotion_description, promotion_code, start_date, end_date, discount_percentage, status) 
                VALUES (:promotion_name, :promotion_description, :promotion_code, :start_date, :end_date, :discount_percentage, :status)",
                [
                    ':promotion_name' => $data['promotion_name'],
                    ':promotion_description' => $data['promotion_description'],
                    ':promotion_code' => $data['promotion_code'],
                    ':start_date' => $data['start_date'],
                    ':end_date' => $data['end_date'],
                    ':discount_percentage' => $data['discount_percentage'],
                    ':status' => $data['status']
                ]
            );
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') { // Integrity constraint violation
                throw new Exception("Duplicate entry detected for promotion code.");
            } else {
                throw $e;
            }
        }
    }

    // Get a single promotion by its ID
    public function getPromotionById($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM promotions WHERE id = :id", [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update an existing promotion by its ID
    public function updatePromotion($id, $data)
    {
        $stmt = $this->pdo->query(
            "UPDATE promotions SET promotion_name = :promotion_name, promotion_description = :promotion_description, 
            promotion_code = :promotion_code, start_date = :start_date, end_date = :end_date, discount_percentage = :discount_percentage, status = :status 
            WHERE id = :id",
            [
                ':promotion_name' => $data['promotion_name'],
                ':promotion_description' => $data['promotion_description'],
                ':promotion_code' => $data['promotion_code'],
                ':start_date' => $data['start_date'],
                ':end_date' => $data['end_date'],
                ':discount_percentage' => $data['discount_percentage'],
                ':status' => $data['status'],
                ':id' => $id
            ]
        );
    }

    // Delete a promotion from the database
    public function deletePromotion($id)
    {
        $this->pdo->query("DELETE FROM promotions WHERE id = :id", [':id' => $id]);
    }
}
