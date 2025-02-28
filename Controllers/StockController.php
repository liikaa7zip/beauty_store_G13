<?php 

    require_once "Models/StockModel.php";
    class StockController extends Basecontroller{
        private $products;
        public function stock_inventory(){
            $this->view('/inventory/stock');
        }

        public function __construct() {
            $this->products = new ProductModel();
        }
        public function index() {
            $products = $this->products->getAllProducts();
            $this->view("inventory/stock", ['products' => $products]);
        }


    }
?>