<?php 

require_once "Models/StockModel.php";
class StockController extends Basecontroller {
    private $products;

    public function __construct() {
        $this->products = new ProductModel();
    }

    public function stock_inventory() {
        $this->view('/inventory/stock');
    }

    public function index() {
        $products = $this->products->getAllProducts();
        $this->view("inventory/stock", ['products' => $products]);
    }

    public function delete($id) {
        $result = $this->products->deleteProducts($id);
        if ($result) {
            header("Location: /inventory/stock");
        } else {
            header("Location: /inventory/stock");
        }
        exit;
    }
}
?>