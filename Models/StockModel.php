<?php 
    class ProductModel {
        private $db;

        public function __construct() {
            $this->db=new Database ("localhost", "beauty_store_data", "root", "");
        }

        public function getAllProducts()
        {
            $result = $this->db->query("SELECT * FROM products");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>