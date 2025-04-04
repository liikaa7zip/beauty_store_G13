<?php
require_once "Database/Database.php";

class HistoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function logLogin($userId, $ipAddress, $userAgent, $status)
    {
        if (!empty($userId) && !empty($ipAddress) && !empty($userAgent) && !empty($status)) {
            $query = "SELECT COUNT(*) FROM user_login_history 
                      WHERE user_id = :user_id AND logout_time IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
    
            if ($stmt->fetchColumn() == 0) {
                $query = "INSERT INTO user_login_history (user_id, ip_address, user_agent, status) 
                          VALUES (:user_id, :ip_address, :user_agent, :status)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':ip_address', $ipAddress);
                $stmt->bindParam(':user_agent', $userAgent);
                $stmt->bindParam(':status', $status);
                $stmt->execute();
            }
        }
    }

    public function logLogout($userId)
    {
        if (!empty($userId)) {
            $query = "UPDATE user_login_history 
                  SET logout_time = CURRENT_TIMESTAMP 
                  WHERE user_id = :user_id AND logout_time IS NULL";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
        }
    }

    public function getLoginHistory()
    {
        $query = "SELECT ulh.*, u.username, u.role 
                  FROM user_login_history ulh
                  JOIN users u ON ulh.user_id = u.id
                  ORDER BY ulh.login_time DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getProductHistory()
    {
        $query = "SELECT ph.product_name, ph.action, u.username AS performed_by, ph.date
                  FROM product_history ph
                  JOIN users u ON ph.user_id = u.id
                  ORDER BY ph.date DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function logProductAction($productName, $action, $userId)
    {
        $query = "INSERT INTO product_history (product_name, action, user_id, date)
                  VALUES (:product_name, :action, :user_id, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_name', $productName);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }
}
