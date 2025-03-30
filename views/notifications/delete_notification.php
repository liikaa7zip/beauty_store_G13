<?php
ob_start(); // Start output buffering

// Require the NotificationModel class
require_once __DIR__ . '/../Models/NotificationsModel.php';

// Create a new instance of the NotificationModel class
$notificationModel = new NotificationModel();

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']); // Ensure integer
    error_log("Received delete request for ID: " . $id); // Debugging log

    if ($notificationModel->deleteNotification($id)) {
        error_log("Successfully deleted notification ID: " . $id);
        echo json_encode(['status' => 'success']);
    } else {
        error_log("Failed to delete notification ID: " . $id);
        echo json_encode(['status' => 'error', 'message' => 'Delete failed in DB']);
    }
    exit;
}

// Fetch notifications from the database
$notifications = $notificationModel->getNotifications();
?>
