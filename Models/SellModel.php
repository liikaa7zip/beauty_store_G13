<?php
class SellModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($data)
    {
        $sql = "INSERT INTO sales (sale_date, total_amount) VALUES (:sale_date, :total_amount)";
        $params = [
            ':sale_date' => $data['sale_date'],
            ':total_amount' => $data['total_amount'],
        ];

        $this->db->query($sql, $params);

        // Return the created sale record
        return $this->db->query("SELECT * FROM sales WHERE id = LAST_INSERT_ID()")->fetch(PDO::FETCH_ASSOC);
    }
}
