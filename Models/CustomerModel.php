<?php

class CustomerModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get customer by ID
    public function getCustomerById($customerId)
    {
        $sql = "SELECT * FROM customers WHERE id = :customer_id";
        $params = [':customer_id' => $customerId];
        return $this->db->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    // Get all customers
    public function getAllCustomers()
    {
        $sql = "SELECT * FROM customers ORDER BY name ASC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update the customer's debt after payment
    public function updateCustomerDebt($customerId, $newDebt)
{
    $sql = "UPDATE customers SET total_debt = :new_debt WHERE id = :customer_id";
    $params = [
        ':new_debt' => $newDebt,
        ':customer_id' => $customerId
    ];
    return $this->db->query($sql, $params);
}

    // In CustomerModel.php
    public function getCustomersWithDebt()
    {
        $sql = "SELECT * FROM customers WHERE total_debt > 0 ORDER BY total_debt DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }


    // Insert a new customer into the database
    public function createCustomer($data)
{
    try {
        $sql = "INSERT INTO customers (name, phone, address, total_debt) 
                VALUES (:name, :phone, :address, :total_debt)";
        
        $params = [
            ':name' => $data['name'],
            ':phone' => $data['phone'],
            ':address' => $data['address'],
            ':total_debt' => $data['total_debt']
        ];

        return $this->db->query($sql, $params);
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        return false;
    }
}

    // Get products not yet paid for by a customer
    public function getUnpaidProductsByCustomerId($customerId)
{
    $sql = "
        SELECT 
            p.name,
            si.quantity,
            si.price,
            s.sale_date,
            (si.quantity * si.price) as total_price
        FROM sales s
        JOIN sale_items si ON s.id = si.sale_id
        JOIN products p ON si.product_id = p.id
        WHERE s.customer_id = :customer_id 
        AND s.payment_status = 'unpaid'
        ORDER BY s.sale_date DESC";
    
    $params = [':customer_id' => $customerId];
    return $this->db->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
}

public function logPayment($customerId, $paymentAmount)
{
    try {
        $sql = "INSERT INTO payments (customer_id, payment_amount, payment_date) 
                VALUES (:customer_id, :payment_amount, NOW())";
        $params = [
            ':customer_id' => $customerId,
            ':payment_amount' => $paymentAmount
        ];
        
        return $this->db->query($sql, $params);
    } catch (PDOException $e) {
        error_log('Database Error: ' . $e->getMessage());
        throw new Exception('Failed to log payment');
    }
}

    public function delete($customerId)
    {
        $sql = "DELETE FROM customers WHERE id = :customer_id";
        $params = [':customer_id' => $customerId];
        return $this->db->query($sql, $params);
    }
  
    

}

