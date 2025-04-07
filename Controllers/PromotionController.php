<?php
require_once "BaseController.php";
require_once "Models/PromotionModel.php";

class PromotionController extends BaseController
{
    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    public function index()
    {
        $promotions = $this->promotionModel->getAllPromotions();
        $this->view("promotion/promotion", ['promotions' => $promotions]);
    }

    public function create()
    {
        $this->view("promotion/create");
    }

    public function store()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'promotion_name' => filter_input(INPUT_POST, 'promotion_name', FILTER_SANITIZE_STRING),
                    'promotion_description' => filter_input(INPUT_POST, 'promotion_description', FILTER_SANITIZE_STRING),
                    'promotion_code' => filter_input(INPUT_POST, 'promotion_code', FILTER_SANITIZE_STRING),
                    'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                    'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                    'discount_percentage' => filter_input(INPUT_POST, 'discount_percentage', FILTER_SANITIZE_NUMBER_INT),
                    'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
                ];

                if (empty($data['promotion_name']) || empty($data['promotion_code'])) {
                    $this->view("promotion/create", ['error' => 'Please fill in all required fields']);
                } else {
                    $this->promotionModel->createPromotion($data);
                    $_SESSION['success'] = "Promotion created successfully!";
                    $this->redirect('/promotion');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            $this->redirect("/promotions/create");
        }
    }

    public function edit($id)
    {
        $promotion = $this->promotionModel->getPromotionById($id);
        if ($promotion) {
            $this->view("promotion/edit", ['promotion' => $promotion]);
        } else {
            $this->redirect('/promotion');
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'promotion_name' => filter_input(INPUT_POST, 'promotion_name', FILTER_SANITIZE_STRING),
                'promotion_description' => filter_input(INPUT_POST, 'promotion_description', FILTER_SANITIZE_STRING),
                'promotion_code' => filter_input(INPUT_POST, 'promotion_code', FILTER_SANITIZE_STRING),
                'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                'discount_percentage' => filter_input(INPUT_POST, 'discount_percentage', FILTER_SANITIZE_NUMBER_INT),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
            ];

            if (empty($data['promotion_name']) || empty($data['promotion_code'])) {
                $this->view("promotion/edit", ['error' => 'Please fill in all required fields', 'promotion' => $data]);
            } else {
                $this->promotionModel->updatePromotion($id, $data);
                $this->redirect('/promotion');
            }
        }
    }

    public function delete($id)
    {
        $this->promotionModel->deletePromotion($id);
        $this->redirect('/promotion');
    }

    public function sendPromotion($promotionId)
{
    try {
        header('Content-Type: application/json');
        $promotion = $this->promotionModel->getPromotionById($promotionId);

        if (!$promotion) {
            echo json_encode(['success' => false, 'message' => 'Promotion not found!']);
            return;
        }

        $db = (new Database())->getConnection();
        $stmt = $db->query("SELECT telegram_chat_id FROM telegram_promotions WHERE telegram_chat_id IS NOT NULL");
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($customers)) {
            echo json_encode(['success' => false, 'message' => 'No customers with Telegram chat IDs found!']);
            return;
        }

        include "views/promotion/telegram-bot.php";
        $telegramBot = new TelegramBot();

        foreach ($customers as $customer) {
            $telegramBot->sendMessage($customer['telegram_chat_id'], $this->formatPromotionMessage($promotion));
        }

        // Log the action in promotion history
        $this->promotionModel->logPromotionAction($promotion['promotion_name'], 'sent', $_SESSION['user_id']);

        echo json_encode(['success' => true, 'message' => 'Promotion sent successfully to all customers!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

    private function formatPromotionMessage($promotion)
    {
        return "🎉 *Promotion Alert!* 🎉\n\n" .
            "*Name:* " . htmlspecialchars($promotion['promotion_name']) . "\n" .
            "*Description:* " . htmlspecialchars($promotion['promotion_description']) . "\n" .
            "*Discount:* " . htmlspecialchars($promotion['discount_percentage']) . "%\n" .
            "*Code:* " . htmlspecialchars($promotion['promotion_code']) . "\n" .
            "*Valid From:* " . htmlspecialchars($promotion['start_date']) . "\n" .
            "*Valid Until:* " . htmlspecialchars($promotion['end_date']) . "\n\n" .
            "Don't miss out on this amazing offer!";
    }
}
