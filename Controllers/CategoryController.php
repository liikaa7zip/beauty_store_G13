<?php 

require_once 'Models/CategoryModel.php';
class CategoryController extends BaseController{
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

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ensure data is received
            if (isset($_POST['category_name']) && isset($_POST['category_description'])) {
                $category_name = trim($_POST['category_name']);
                $category_description = trim($_POST['category_description']);
    
                if (!empty($category_name) && !empty($category_description)) {
                    $result = $this->categoryModel->createCategories($category_name, $category_description);
                    
                    if ($result) {
                        header('Location: /inventory/products'); // Ensure this URL is correct
                        exit();
                    } else {
                        echo "Error inserting data into the database.";
                    }
                } else {
                    echo "Both category name and description are required.";
                }
            } else {
                echo "Invalid form submission.";
            }
            print_r($_POST);
            exit();
        }
    }
}
?>