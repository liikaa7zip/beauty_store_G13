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

    
}
