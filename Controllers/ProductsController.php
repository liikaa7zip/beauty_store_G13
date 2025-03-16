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

    public function edit($id) {
        $product = $this->productModel->getProductByID($id);
        $categories = $this->categoryModel->getAllCategories();
        if ($product) {
            $this->view("inventory/edit", ['product' => $product, 'categories' => $categories]);
        } else {
            $_SESSION['error'] = "Product not found!";
            $this->redirect("/inventory/products");
        }
    }

    public function store() {
        // Get POST data
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $stocks = $_POST['stocks'] ?? '';
        $status = $_POST['status'] ?? 'instock';

        // Validation (basic example)
        if (empty($name) || empty($price) || empty($category_id)) {
            $_SESSION['error'] = "Please fill all required fields.";
            $this->redirect("/inventory/products/create");
            return;
        }

        // Prepare data
        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'stocks' => $stocks,
            'status' => $status
        ];

        // Store the product in the database
        if ($this->productModel->storeProduct($data)) {
            $_SESSION['success'] = "Product added successfully!";
            $this->redirect("/inventory/products");
        } else {
            $_SESSION['error'] = "Failed to add product.";
            $this->redirect("/inventory/products/create");
        }
    }

    public function update($id) {
        // Get the POST data
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $stocks = $_POST['stocks'] ?? '';
        $status = $_POST['status'] ?? 'instock';

        // Validation (basic example)
        if (empty($name) || empty($price) || empty($category_id)) {
            $_SESSION['error'] = "Please fill all required fields.";
            $this->redirect("/inventory/edit/$id");
            return;
        }

        // Prepare data for update
        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'stocks' => $stocks,
            'status' => $status
        ];

        // Update the product
        if ($this->productModel->updateProduct($id, $data)) {
            $_SESSION['success'] = "Product updated successfully!";
            $this->redirect("/inventory/products");
        } else {
            $_SESSION['error'] = "Failed to update product.";
            $this->redirect("/inventory/edit/$id");
        }
    }

    public function delete($id) {
        if ($this->productModel->deleteProduct($id)) {
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

