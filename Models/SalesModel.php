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
        $stmt = $this->db->query("SELECT id, sale_date, total_amount FROM sales");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSallesLastWeeks()
    {
        // Fetch sales from the last 7 days
        $stmt = $this->db->query("SELECT * FROM sales WHERE sale_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)");
        $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Initialize an array for the past 7 days with 0 amounts
        $totalSales = [];
        for ($i = 6; $i >= 0; $i--) {
            $dateKey = date('Y-m-d', strtotime("-$i days")); // Generate past 7 days
            $totalSales[$dateKey] = 0;
        }

        // Loop through sales and sum the total amount per day
        foreach ($sales as $sale) {
            $dateKey = date('Y-m-d', strtotime($sale['sale_date'])); // Extract only date (YYYY-MM-DD)
            if (isset($totalSales[$dateKey])) {
                $totalSales[$dateKey] += $sale['total_amount'];
            }
        }

        // Return values as an indexed array (latest day first)
        return array_values($totalSales);
    }

    public function getTotalProductSell($month, $year)
{
    $query = "SELECT 
                products.name, 
                SUM(sale_items.quantity) AS total_products, 
                SUM(sale_items.price) AS total_revenue, 
                SUM(sale_items.quantity * products.original_price) AS total_cost, 
                (SUM(sale_items.price) - SUM(sale_items.quantity * products.original_price)) AS total_profit
              FROM sale_items 
              INNER JOIN products ON products.id = sale_items.product_id 
              INNER JOIN sales ON sales.id = sale_items.sale_id
              WHERE MONTH(sales.sale_date) = :month AND YEAR(sales.sale_date) = :year
              GROUP BY sale_items.product_id";

    $stmt = $this->db->prepare($query);
    $stmt->execute(['month' => $month, 'year' => $year]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalProfit = array_sum(array_column($data, 'total_profit')); // Sum all profits

    return [
        'label' => array_column($data, 'name'),
        'data' => array_column($data, 'total_profit'),
        'total_profit' => $totalProfit
    ];
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
