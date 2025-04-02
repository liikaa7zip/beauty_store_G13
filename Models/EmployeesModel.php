<?php
class EmployeesModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllEmployees()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }

    public function createUser($data)
    {
        try {
            $this->db->query(
                "INSERT INTO users (username, image, email, password, role) 
                 VALUES (:username, :image, :email, :password, :role)",
                [
                    ':username' => $data['username'],
                    ':image' => $data['image'],
                    ':email' => $data['email'],
                    ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                    ':role' => $data['role']
                ]
            );
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        $stmt = $this->db->query("SELECT * FROM users WHERE id = :id", [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($data)
    {
        $this->db->query(
            "UPDATE users SET username = :username, image = :image, email = :email, password = :password, role = :role WHERE id = :id",
            [
                ':username' => $data['username'],
                ':image' => $data['image'],
                ':email' => $data['email'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':role' => $data['role'],
                ':id' => $data['id']
            ]
        );
    }

    public function handleUpload()
    {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $targetDir = 'uploads/';
            $fileName = basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . uniqid() . '_' . $fileName;
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
            return $targetFilePath;
        }
        return false;
    }

    

    public function deleteUser($id){
        $this->db->query("DELETE FROM users WHERE id = :id", [':id' => $id]);
    }
}
