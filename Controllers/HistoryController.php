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
        error_log("logLogin called for user ID: $userId");
        if (!empty($userId) && !empty($ipAddress) && !empty($userAgent) && !empty($status)) {
            $this->historyModel->logLogin($userId, $ipAddress, $userAgent, $status);
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
            $this->historyModel->logLogout($userId);
        }
    }

    /**
     * Displays the user login history.
     */
    public function index()
    {
        $history = $this->historyModel->getLoginHistory();
        if (!is_array($history)) {
            $history = [];
        }
        $this->view('/history/userHistory', ['history' => $history]);
    }
}

// Example: Define $userId for testing or ensure it is retrieved from the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user_id'] ?? null; // Retrieve user ID from session

if ($userId) {
    $historyController = new HistoryController();
    $historyController->logLogin($userId, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], 'success');
} else {
    echo "Error: User ID is not defined.";
}
