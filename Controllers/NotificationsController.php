<?php

class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new NotificationModel();
    }

    public function index() {
        $notifications = $this->notificationModel->getAllNotifications();
        // include __DIR__ . 'notification/notification';
        include __DIR__ . '/../views/notifications/notifications.php';
    }
    
}