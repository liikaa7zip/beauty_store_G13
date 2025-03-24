<?php 

    // class EmployeesModel 
    // {
    //     private $db;

    //     public function __construct() {
    //         $this->db = new Database();
    //     }

    //     public function getAllEmployees() {
    //         $stmt = $this->db->query("SELECT * FROM employees");
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     }
    // }



/*
 * Copyright (c) 2025 Your Name. All rights reserved.
 * This code is for personal use and may not be redistributed without permission.
 */

 class EmployeesModel 
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllEmployees() {
        try {
            $stmt = $this->db->query("SELECT * FROM employees");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching employees: " . $e->getMessage());
            return [];
        }
    }

    public function addEmployee($username, $role, $contact = "N/A", $status = "Active", $email = null, $password = null) {
        try {
            $sql = "INSERT INTO employees (username, email, password, role, created_at, updated_at, action, status, contact, profile_image_url) 
                    VALUES (:username, :email, :password, :role, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(), :action, :status, :contact, :profile_image_url)";
            
            $stmt = $this->db->query($sql, [
                ':username' => $username,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role,
                ':action' => NULL,
                ':status' => $status,
                ':contact' => $contact,
                ':profile_image_url' => NULL
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Error adding employee: " . $e->getMessage());
            return false;
        }
    }
}
?>