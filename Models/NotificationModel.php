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
        $query = "SELECT id, notification_title, notification_message, notification_type, 
                 start_date, end_date, status, created_at 
                 FROM store_notifications";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNotification($notification_title, $notification_message, $notification_type, 
                                  $start_date, $end_date, $status) {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO store_notifications 
                 (notification_title, notification_message, notification_type, 
                  start_date, end_date, status, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->query($query, [
            $notification_title, 
            $notification_message, 
            $notification_type, 
            $start_date, 
            $end_date, 
            $status, 
            $created_at
        ]);
        return $this->db->lastInsertId();
    }

    public function createNotification($title, $message, $type) {
        return $this->addNotification(
            $title,
            $message,
            $type,
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s', strtotime('+7 days')),
            'active'
        );
    }

    public function deleteNotification($id) {
        $query = "DELETE FROM store_notifications WHERE id = ?";
        $stmt = $this->db->query($query, [$id]);
        return $stmt->rowCount();
    }
}
