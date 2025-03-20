<?php
// Models/SalesModel.php

class SalesModel {
    private $db;

    public function __construct() {
        // Replace with your actual database credentials
        $host = 'localhost';
        $dbname = 'beauty_store_data'; // Adjust to your database name
        $username = 'root';       // Default XAMPP/WAMP username; change if different
        $password = '';           // Default XAMPP/WAMP password; change if different

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getProducts() {
        // Dummy data since no products table exists yet
        return [
            ['id' => 1, 'name' => 'Lipstick', 'sales' => 150],
            ['id' => 2, 'name' => 'Foundation', 'sales' => 120],
            ['id' => 3, 'name' => 'Mascara', 'sales' => 90]
        ];
    }

    public function getSales() {
        // Fetch sales from the sales table and group by month
        $stmt = $this->db->prepare("
            SELECT 
                DATE_FORMAT(sale_date, '%b') AS month, 
                SUM(total_amount) AS amount
            FROM sales
            WHERE YEAR(sale_date) = 2023
            GROUP BY DATE_FORMAT(sale_date, '%b')
            ORDER BY MONTH(sale_date)
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert to associative array with month as key
        $sales = [];
        foreach ($results as $row) {
            $sales[$row['month']] = (int)$row['amount'];
        }

        // Ensure all months (Jan-Jun) are present with 0 if no sales
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        foreach ($months as $month) {
            if (!isset($sales[$month])) {
                $sales[$month] = 0;
            }
        }
        ksort($sales); // Sort by month order
        return $sales;
    }

    public function getStockLevels() {
        // Dummy data since no stock table exists yet
        return [
            'Lipstick' => 50,
            'Foundation' => 30,
            'Mascara' => 20
        ];
    }
}