<?php
require_once "Models/ProductModel.php";

class ProductsController extends BaseController {
    private $products;

    public function __construct() {
        $this->products = new ProductModel();
    }

    public function index() {
        $products = $this->products->getAllProducts();
        $this->view("inventory/products", ['products' => $products]);
    }

    public function delete($id) {
        if ($this->products->deleteProducts($id)) {
            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete product.";
        }
        header("Location: /inventory/products");
        exit;
    }
    
}
?>
