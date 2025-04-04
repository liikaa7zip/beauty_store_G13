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


    // new code
    private function createLowStockNotification($productName, $stocks) {
        $message = "The product '$productName' is running low with only $stocks items left in stock.";

        $sql = "INSERT INTO store_notifications 
                (notification_title, notification_message, notification_type, start_date, end_date, status) 
                VALUES (:title, :message, :type, :start_date, :end_date, :status)";

        $params = [
            ':title' => "Low Stock Alert: $productName",
            ':message' => $message,
            ':type' => 'low_stock',
            ':start_date' => date('Y-m-d H:i:s'),
            ':end_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
            ':status' => 'active'
        ];

        return $this->db->query($sql, $params);
    }




    
    public function deleteNotification($id) {
        try {
            $query = "DELETE FROM store_notifications WHERE id = ?";
            $stmt = $this->db->prepare($query); // Prepare query
            $stmt->execute([$id]); // Execute with parameter
    
            if ($stmt->rowCount() > 0) {
                error_log("Database delete success for ID: " . $id);
                return true;
            } else {
                error_log("Database delete failed for ID: " . $id);
                return false;
            }
        } catch (PDOException $e) {
            error_log("PDO Error deleting notification: " . $e->getMessage());
            return false;
        }
    }
}
