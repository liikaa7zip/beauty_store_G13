<?php
require_once "Models/HistoryModel.php";
require_once "BaseController.php";

class HistoryController extends BaseController
{
    private $historyModel;

    public function __construct()
    {
        $this->historyModel = new HistoryModel();
    }

    public function logLogin($userId, $ipAddress, $userAgent, $status)
    {
        if (!empty($userId) && !empty($ipAddress) && !empty($userAgent) && !empty($status)) {
            $this->historyModel->logLogin($userId, $ipAddress, $userAgent, $status);
        }
    }

    public function logLogout($userId)
    {
        if (!empty($userId)) {
            $this->historyModel->logLogout($userId);
        }
    }


    public function index()
    {
        $type = $_GET['type'] ?? 'login'; // Default to 'login' history
        $userId = $_GET['user_id'] ?? null; // Get the user ID if provided

        switch ($type) {
            case 'product':
                $history = $userId ? $this->historyModel->getProductHistoryByUser($userId) : $this->historyModel->getProductHistory();
                $this->view('/history/productHistory', ['history' => $history]);
                break;

                case 'sell':
                $history = $userId ? $this->historyModel->getSellHistoryByUser($userId) : $this->historyModel->getSellHistory();
                $this->view('/history/sellHistory', ['history' => $history]);
                break;
            case 'category':
                $history = $userId ? $this->historyModel->getCategoryHistoryByUser($userId) : $this->historyModel->getCategoryHistory();
                $this->view('/history/categoryHistory', ['history' => $history]);
                break;

            case 'promotion':
                $history = $userId ? $this->historyModel->getPromotionHistoryByUser($userId) : $this->historyModel->getPromotionHistory();
                $this->view('/history/promotionHistory', ['history' => $history]);
                break;

            default: // Default to login history
                $history = $this->historyModel->getLoginHistory();
                $this->view('/history/userHistory', ['history' => $history]);
                break;
        }
    }
}


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user_id'] ?? null;

if ($userId) {
    $historyController = new HistoryController();
    $historyController->logLogin($userId, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'success');
}
