<?php

class SalesModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSales()
    {
        $stmt = $this->db->query("SELECT * FROM sales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
