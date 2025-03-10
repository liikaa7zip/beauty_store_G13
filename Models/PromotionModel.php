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
         $stmt = $this->pdo->query("INSERT INTO promotions (product_id, discount, start_date, end_date) VALUES (:product_id, :discount, :start_date, :end_date)",[
             ':product_id' => $data['product_id'],
             ':discount' => $data['discount'],
             ':start_date' => $data['start_date'],
             ':end_date' => $data['end_date']
         ]);

    }

    function update_promotion($data)
    {
        $stmt = $this->pdo->query("UPDATE promotions SET product_id = :product_id, discount = :discount, start_date = :start_date, end_date = :end_date WHERE id = :id",[
            ':product_id' => $data['product_id'],
            ':discount' => $data['discount'],
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':id' => $data['id']
        ]);
    }

    function deletePromotion($id)
    {
        $stmt = $this->pdo->query("DELETE FROM promotions WHERE id = :id",[
            ':id' => $id
        ]);
    }
}