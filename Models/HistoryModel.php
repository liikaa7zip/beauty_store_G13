<?php
require_once "Database/Database.php";

class HistoryModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    /**
     * Logs a user login event.
     *
     * @param int $userId The ID of the user.
     * @param string $ipAddress The IP address of the user.
     * @param string $userAgent The user agent string of the user's browser.
     * @param string $status The status of the login attempt ('success' or 'failed').
     */
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

    /**
     * Logs a user logout event.
     *
     * @param int $userId The ID of the user.
     */
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

    /**
     * Retrieves the login history of all users.
     *
     * @return array The login history records.
     */
    public function getLoginHistory()
    {
        $query = "SELECT ulh.*, u.username, u.role 
                  FROM user_login_history ulh
                  JOIN users u ON ulh.user_id = u.id
                  ORDER BY ulh.login_time DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}
