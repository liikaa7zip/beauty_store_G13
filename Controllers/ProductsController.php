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

    // Method to display all products, initially without filtering
    public function index() {
        // Get all categories to show in the select dropdown
        $categories = $this->categoryModel->getAllCategories();

        // Fetch all products initially
        $products = $this->productModel->getAllProducts();

        // Process products to add category names and format prices
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
            
            // Automatically set status based on stock level
            if ($product['stocks'] <= 5 && $product['status'] !== 'low-stock') {
                $product['status'] = 'low-stock';
                $this->productModel->updateProduct($product['id'], [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'category_id' => $product['category_id'],
                    'stocks' => $product['stocks'],
                    'status' => 'low-stock'
                ]);
            }
        }

        // Pass categories and products to the view
        $this->view("inventory/products", ['products' => $products, 'categories' => $categories]);
    }

    // Method to handle AJAX filtering of products by category
    public function filter() {
        $category_id = $_GET['category'] ?? null;

        // If a category is selected, filter products by that category
        if ($category_id) {
            $products = $this->productModel->getProductsByCategory($category_id);
        } else {
            $products = $this->productModel->getAllProducts();
        }

        // Process the filtered products
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $stocks = $_POST['stocks'] ?? '';
            $status = $_POST['status'] ?? 'instock';

            // Handle image upload
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
                $imagePath = $this->uploadImage($_FILES['productImage']);
            }

            if (empty($name) || empty($price) || empty($category_id)) {
                $_SESSION['error'] = "Please fill all required fields.";
                $this->redirect("/inventory/products/create");
                return;
            }

            $data = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'stocks' => $stocks,
                'status' => $status,
                'image' => isset($imagePath) ? $imagePath : ''
            ];

            if ($this->productModel->storeProduct($data)) {
                $_SESSION['success'] = "Product added successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to add product.";
                $this->redirect("/inventory/products/create");
            }
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $stocks = $_POST['stocks'] ?? '';
            $status = $_POST['status'] ?? 'instock';

            // Handle image upload
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
                $imagePath = $this->uploadImage($_FILES['productImage']);
                // Delete the old image if a new one is uploaded
                $oldImage = $this->productModel->getProductByID($id)['image'];
                if (!empty($oldImage) && file_exists($oldImage)) {
                    unlink($oldImage);
                }
            } else {
                $imagePath = $this->productModel->getProductByID($id)['image'];
            }

            if (empty($name) || empty($price) || empty($category_id)) {
                $_SESSION['error'] = "Please fill all required fields.";
                $this->redirect("/inventory/edit/$id");
                return;
            }

            $data = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'stocks' => $stocks,
                'status' => $status,
                'image' => $imagePath
            ];

            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success'] = "Product updated successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to update product.";
                $this->redirect("/inventory/edit/$id");
            }
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
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? ''; 
            $stocks = $_POST['stocks'];
            $category_id = $_POST['category_id'];
            $status = $_POST['status'] ?? 'in-stock';

            // Handle image upload
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
                $imagePath = $this->uploadImage($_FILES['productImage']);
            }

            $data = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stocks' => $stocks,
                'category_id' => $category_id,
                'status' => $status,
                'image' => isset($imagePath) ? $imagePath : ''
            ];

            if ($this->productModel->createProduct($data)) {
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

    private function uploadImage($file) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);
    
        // Ensure the directory exists and is writable
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    
        // Check for valid image and move the file
        if (getimagesize($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                return $uploadFile;
            } else {
                $_SESSION['error'] = "File upload failed.";
            }
        } else {
            $_SESSION['error'] = "Uploaded file is not a valid image.";
        }
    
        return '';
    }
    
    private function getImageUrl($imagePath) {
        if (!empty($imagePath) && file_exists($imagePath)) {
            return '/' . $imagePath;
        }
        return '/uploads/default-image.jpg';
    }
}