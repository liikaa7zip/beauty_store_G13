<?php

class NotificationModel {
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../Database/Database.php'; // Ensure Database class is included
        $this->db = new Database();
    }

    public function getAllNotifications() {
        $query = "SELECT * FROM store_notifications";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNotification($notification_title, $notification_message, $notification_type, $start_date, $end_date, $status) {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO store_notifications (notification_title, notification_message, notification_type, start_date, end_date, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$notification_title, $notification_message, $notification_type, $start_date, $end_date, $status, $created_at]);
        
        return $this->db->lastInsertId();
    }

    public function getNotifications() {
        $query = "SELECT id, notification_title, notification_message, notification_type, start_date, end_date, status, created_at FROM store_notifications";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteNotification($id) {
        try {
            $checkQuery = "SELECT id FROM store_notifications WHERE id = ?";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->execute([$id]);
            
            if ($stmt->rowCount() === 0) {
                error_log("Delete failed: Notification ID $id not found.");
                return false;
            }

            $deleteQuery = "DELETE FROM store_notifications WHERE id = ?";
            $stmt = $this->db->prepare($deleteQuery);
            $stmt->execute([$id]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("PDO Error deleting notification: " . $e->getMessage());
            return false;
        }
    }   
}
?>
