<?php
class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllNotifications() {
        $query = "SELECT * FROM store_notifications";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveNotifications() {
        $query = "SELECT * FROM store_notifications 
                 WHERE status = 'active' 
                 AND start_date <= NOW() 
                 AND end_date >= NOW()";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNotifications() {
        $query = "SELECT id, notification_title, notification_message, notification_type, start_date, end_date, status, created_at FROM store_notifications";
        $result = $this->db->query($query);

        $notifications = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $notifications[] = $row;
            }
        }
        return $notifications;
    }


    public function deleteNotification($id) {
        try {
            $query = "DELETE FROM store_notifications WHERE id = ?";
            $stmt = $this->db->prepare($query); // Prepare query
            $stmt->execute([$id]); // Execute with parameter

            if ($stmt->rowCount() > 0) {
                return true; // Successfully deleted
            } else {
                return false; // No rows affected
            }
        } catch (PDOException $e) {
            error_log("Error deleting notification: " . $e->getMessage());
            return false;
        }
    }
}
