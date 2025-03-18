<?php 

class CategoryController {
    private $categoryModel;
    private $productModel;

    public function __construct($db) {
        $this->categoryModel = new CategoryModel($db);
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();

        $category_name = isset($_GET['category']) ? $_GET['category'] : null;
        $products = $this->productModel->getProductsByCategoryName($category_name);

        require_once 'views/category_view.php';
    }
}


?>