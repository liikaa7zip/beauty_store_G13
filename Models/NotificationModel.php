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

    public function addNotification($notification_title, $notification_message, $notification_type, $start_date, $end_date, $status) {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO store_notifications (notification_title, notification_message, notification_type, start_date, end_date, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->query($query, [$notification_title, $notification_message, $notification_type, $start_date, $end_date, $status, $created_at]);
        return $this->db->lastInsertId();
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
        $query = "DELETE FROM store_notifications WHERE id = ?";
        $stmt = $this->db->query($query, [$id]);
        return $stmt->rowCount();
    }
}
?>