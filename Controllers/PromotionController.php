<?php

require_once "BaseController.php";
require_once "Models/PromotionModel.php";

class PromotionController extends BaseController
{
    private $promotionModel;

    // Initialize the PromotionModel instance
    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    // Display a list of all promotions
    public function index()
    {
        $promotions = $this->promotionModel->getAllPromotions();
        $this->view("promotion/promotion", ['promotions' => $promotions]);
    }

    // Show the form to create a new promotion
    public function create()
    {
        $this->view("promotion/create");
    }

    // Handle the creation of a new promotion
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and sanitize input data
            $data = [
                'promotion_name' => filter_input(INPUT_POST, 'promotion_name', FILTER_SANITIZE_STRING),
                'promotion_description' => filter_input(INPUT_POST, 'promotion_description', FILTER_SANITIZE_STRING),
                'promotion_code' => filter_input(INPUT_POST, 'promotion_code', FILTER_SANITIZE_STRING),
                'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                'discount_percentage' => filter_input(INPUT_POST, 'discount_percentage', FILTER_SANITIZE_NUMBER_INT),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
            ];

            // Basic validation for required fields
            if (empty($data['promotion_name']) || empty($data['promotion_code'])) {
                $this->view("promotion/create", ['error' => 'Please fill in all required fields']);
            } else {
                $this->promotionModel->createPromotion($data);
                $this->redirect('/promotion');
            }
        }
    }

    // Show the form to edit an existing promotion
    public function edit($id)
    {
        $promotion = $this->promotionModel->getPromotionById($id);
        if ($promotion) {
            $this->view("promotion/edit", ['promotion' => $promotion]);
        } else {
            $this->redirect('/promotion');
        }
    }

    // Handle the update of an existing promotion
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Collect and sanitize input data
            $data = [
                'promotion_name' => filter_input(INPUT_POST, 'promotion_name', FILTER_SANITIZE_STRING),
                'promotion_description' => filter_input(INPUT_POST, 'promotion_description', FILTER_SANITIZE_STRING),
                'promotion_code' => filter_input(INPUT_POST, 'promotion_code', FILTER_SANITIZE_STRING),
                'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                'discount_percentage' => filter_input(INPUT_POST, 'discount_percentage', FILTER_SANITIZE_NUMBER_INT),
                'status' => filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING)
            ];

            // Basic validation for required fields
            if (empty($data['promotion_name']) || empty($data['promotion_code'])) {
                $this->view("promotion/edit", ['error' => 'Please fill in all required fields', 'promotion' => $data]);
            } else {
                $this->promotionModel->updatePromotion($id, $data);
                $this->redirect('/promotion');
            }
        }
    }

    // Handle the deletion of a promotion
    public function delete($id)
    {
        $this->promotionModel->deletePromotion($id);
        $this->redirect('/promotion');
    }
}
