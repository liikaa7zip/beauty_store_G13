<?php
class PromotionModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }

    function getAllPromotions()
    {
        $result = $this->pdo->query("SELECT * FROM promotions");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    function create_promotion($data)
    {
        $stmt = $this->pdo->query(
            "INSERT INTO promotions (promotion_name, promotion_description, promotion_code, start_date, end_date, discount_percentage, status) 
            VALUES (:promotion_name, :promotion_description, :promotion_code, :start_date, :end_date, :discount_percentage, :status)", [
            ':promotion_name' => $data['promotion_name'],
            ':promotion_description' => $data['promotion_description'],
            ':promotion_code' => $data['promotion_code'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':discount_percentage' => $data['discount_percentage'],
            ':status' => $data['status']
        ]);
    }

    function update_promotion($id, $data)
    {
        $stmt = $this->pdo->query(
            "UPDATE promotions SET promotion_name = :promotion_name, promotion_description = :promotion_description, 
            discount_percentage = :discount_percentage, start_date = :start_date, end_date = :end_date, status = :status 
            WHERE id = :id", [
            ':promotion_name' => $data['promotion_name'],
            ':promotion_description' => $data['promotion_description'],
            ':discount_percentage' => $data['discount_percentage'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
    }

    function deletePromotion($id)
{
    $stmt = $this->pdo->query("DELETE FROM promotions WHERE id = :id", [':id' => $id]);
}

}
