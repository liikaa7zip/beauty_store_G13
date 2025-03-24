<?php
require_once "Database/Database.php";

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database('localhost', 'beauty_store_data', 'root', '');
    }


    public function getUserByEmail($email) {
        $result = $this->db->query("SELECT * FROM users WHERE email = :email", [':email' => $email]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username) {
        $result = $this->db->query("SELECT * FROM users WHERE username = :username", [':username' => $username]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    
}
?>