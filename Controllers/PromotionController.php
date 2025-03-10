<?php 

    require_once "Models/PromotionModel.php";
    class PromotionController extends BaseController{
        private $products;
        public function promotions(){
            $this->view('/promotion/promotion');
        }

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
            
        }

        function destroy($id)
        {
            $this->products->deletePromotion($id);
            $this -> redirect('/promotion/promotion');   
        }
    }