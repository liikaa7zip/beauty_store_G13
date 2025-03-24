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

    public function create($data)
{
    // Log or print SQL and parameters to check the values
    error_log("SQL: INSERT INTO sale_items (sale_id, product_id, quantity, price) VALUES (:sale_id, :product_id, :quantity, :price)");
    error_log("Params: " . print_r($data, true));
    
    $sql = "INSERT INTO sale_items (sale_id, product_id, quantity, price) VALUES (:sale_id, :product_id, :quantity, :price)";
    $params = [
        ':sale_id' => $data['sale_id'],
        ':product_id' => $data['product_id'],
        ':quantity' => $data['quantity'],
        ':price' => $data['price']
    ];
    
    // Execute query
    return $this->db->query($sql, $params);
}

}
?>
