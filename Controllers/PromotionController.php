<?php 

    require_once "Models/PromotionModel.php";
    class PromotionController extends BaseController{
        private $products;
        public function __construct() {
            $this->products = new PromotionModel();
        }
        public function index() {
            $promotions = $this->products->getAllPromotions();
            $this->view("promotion/promotion", ['promotions' => $promotions]);
        }

        public function create () {
           $this->view("promotion/create");
        }

        function store () {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'promotion_name' => $_POST['promotion_name'],
                    'promotion_description' => $_POST['promotion_description'],
                    'promotion_code' => $_POST['promotion_code'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'status' => $_POST['status'],
                ];
                $this->products->create_promotion($data);
                $this->redirect('/promotion');
            }
        }

        function delete($id) {
            $this->products->deletePromotion($id);
            $this->redirect('/promotion');
        }
        
    }