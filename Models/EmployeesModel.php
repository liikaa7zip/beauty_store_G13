<?php 

    class EmployeesModel 
    {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function getAllEmployees() {
            $stmt = $this->db->query("SELECT * FROM employees");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>