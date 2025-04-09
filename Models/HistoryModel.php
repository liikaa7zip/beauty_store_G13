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

    public function getProductHistoryByUser($userId)
    {
        $query = "SELECT ph.product_name, ph.action, u.username AS performed_by, ph.date
                  FROM product_history ph
                  JOIN users u ON ph.user_id = u.id
                  WHERE ph.user_id = :user_id
                  ORDER BY ph.date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getCategoryHistory()
    {
        $query = "SELECT ch.category_name, ch.action, ch.user_id, u.username AS performed_by, ch.date
              FROM category_history ch
              JOIN users u ON ch.user_id = u.id
              ORDER BY ch.date DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getCategoryHistoryByUser($userId)
    {
        $query = "SELECT ch.category_name, ch.action, u.username AS performed_by, ch.date
              FROM category_history ch
              JOIN users u ON ch.user_id = u.id
              WHERE ch.user_id = :user_id
              ORDER BY ch.date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function logCategoryAction($categoryName, $action, $userId)
    {
        $query = "INSERT INTO category_history (category_name, action, user_id, date)
              VALUES (:category_name, :action, :user_id, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':category_name', $categoryName);
        $stmt->bindParam(':action', $action);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }


    public function getPromotionHistory()
    {
        $query = "SELECT ph.promotion_name, ph.action, u.username AS performed_by, ph.date
              FROM promotion_history ph
              JOIN users u ON ph.user_id = u.id
              ORDER BY ph.date DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    public function getPromotionHistoryByUser($userId)
    {
        $query = "SELECT ph.promotion_name, ph.action, u.username AS performed_by, ph.date
              FROM promotion_history ph
              JOIN users u ON ph.user_id = u.id
              WHERE ph.user_id = :user_id
              ORDER BY ph.date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // public function getSellHistory()
    // {
    //     $query = "SELECT si.product_name, si.price AS amount, si.quantity, u.username AS performed_by, s.sale_date AS date
    //           FROM sale_items si
    //           JOIN sales s ON si.sale_id = s.id
    //           JOIN users u ON s.user_id = u.id
    //           ORDER BY s.sale_date DESC";
    //     $stmt = $this->db->query($query);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    // }

    public function getSellHistory()
    {
        $query = "SELECT si.product_name, si.price AS amount, si.quantity, u.username AS performed_by, s.sale_date AS date
              FROM sale_items si
              JOIN sales s ON si.sale_id = s.id
              JOIN users u ON s.user_id = u.id
              ORDER BY s.sale_date DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getSellHistoryByUser($userId)
{
    $query = "SELECT 
                sh.product_name, 
                sh.amount, 
                sh.quantity, 
                u.username AS performed_by, 
                sh.sale_date
              FROM sell_history sh
              JOIN users u ON sh.performed_by = u.id
              WHERE sh.performed_by = :user_id
              ORDER BY sh.sale_date DESC";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
}
