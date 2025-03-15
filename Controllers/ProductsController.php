<?php
require_once "Models/ProductModel.php";
require_once "Models/CategoryModel.php";

class ProductsController extends BaseController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }
        $this->view("inventory/products", ['products' => $products]);
    }

    public function delete($id) {
        if ($this->productModel->deleteProducts($id)) {
            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete product.";
        }
        header("Location: /inventory/products");
        exit;
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $stocks = $_POST['stocks'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'] ?? 'in-stock'; // Default to 'in-stock' if not provided

            if ($this->productModel->createProduct($name, $stocks, $category_id, $status)) {
                $_SESSION['success'] = "Product created successfully!";
                header("Location: /inventory/products");
                exit;
            } else {
                $_SESSION['error'] = "Failed to create product.";
            }
        }
        $categories = $this->categoryModel->getAllCategories();
        $this->view("inventory/create", ['categories' => $categories]);
    }
}
?>

