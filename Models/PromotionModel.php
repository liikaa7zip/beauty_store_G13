<?php
class PromotionModel
{
    private $pdo;

    function __construct()
    {
        $this->pdo = new Database();
    }
    public function getAllPromotions()
    {
        $result = $this->pdo->query("SELECT * FROM promotions");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}