<?php

class PromotionModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new Database();
    }

    public function getAllPromotions()
    {
        $stmt = $this->pdo->query("SELECT * FROM promotions ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

            // Log the action
            $this->logPromotionAction($data['promotion_name'], 'created', $_SESSION['user_id']);
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                throw new Exception("Duplicate entry detected for promotion code.");
            } else {
                throw $e;
            }
        }
    }

    public function getPromotionById($id)
    {
        $stmt = $this->pdo->query("SELECT * FROM promotions WHERE id = :id", [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

        // Log the action
        $this->logPromotionAction($data['promotion_name'], 'updated', $_SESSION['user_id']);
    }

    public function deletePromotion($id)
    {
        $promotion = $this->getPromotionById($id);
        $this->pdo->query("DELETE FROM promotions WHERE id = :id", [':id' => $id]);
        $this->logPromotionAction($promotion['promotion_name'], 'deleted', $_SESSION['user_id']);
    }
    public function logPromotionAction($promotionName, $action, $userId)
    {
        $stmt = $this->pdo->query(
            "INSERT INTO promotion_history (promotion_name, action, user_id, date) 
            VALUES (:promotion_name, :action, :user_id, CURRENT_TIMESTAMP)",
            [
                ':promotion_name' => $promotionName,
                ':action' => $action,
                ':user_id' => $userId
            ]
        );
    }
}
