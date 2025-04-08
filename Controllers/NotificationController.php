<?php
require_once "Models/NotificationModel.php";
require_once "Models/ProductModel.php";

class NotificationController extends BaseController {
    private $notificationModel;
    private $productModel;

    public function __construct() {
        $this->notificationModel = new NotificationModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        // Generate low-stock notifications
        $this->generateLowStockNotifications();
        // // Fetch active notifications
        $notifications = $this->notificationModel->getActiveNotifications();
        $lowStockProducts = $this->productModel->getLowStockProducts();
        

        // Check if the request is AJAX
        if ($this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'notifications' => $notifications,
                'lowStockProducts' => $lowStockProducts
            ]);
            exit;
        }
        
        // Regular request - render view
        $this->view('notification/notification', [
            'notifications' => $notifications,
            'lowStockProducts' => $lowStockProducts
        ]);
    }

    public function getLowStockNotifications() {
        $lowStockProducts = $this->productModel->getLowStockProducts();
        header('Content-Type: application/json');
        echo json_encode($lowStockProducts);
        exit;
    }

    private function isAjaxRequest() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }


    public function generateLowStockNotifications() {
        $lowStockProducts = $this->productModel->getLowStockProducts();
    
        foreach ($lowStockProducts as $product) {
            // Check if a notification for this product already exists
            $existingNotifications = $this->notificationModel->getAllNotifications();
            $exists = false;
    
            foreach ($existingNotifications as $notification) {
                if ($notification['notification_title'] === "Low Stock Alert: {$product['name']}") {
                    $exists = true;
                    break;
                }
            }
    
            if (!$exists) {
                // Create a new notification for the low-stock product
                $this->notificationModel->createLowStockNotification($product['name'], $product['stocks']);
            }
        }
    }
}