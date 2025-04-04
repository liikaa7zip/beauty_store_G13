<?php
require_once "Models/ProductModel.php";
require_once "Models/CategoryModel.php";

class ProductsController extends BaseController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    // Method to display all products, initially without filtering
    public function index()
    {
        // Get all categories to show in the select dropdown
        $categories = $this->categoryModel->getAllCategories();

        // Fetch all products initially
        $products = $this->productModel->getAllProducts();

        // Process products to add category names and format prices
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        // Pass categories and products to the view
        $this->view("inventory/products", ['products' => $products, 'categories' => $categories]);
    }

    // Method to handle AJAX filtering of products by category
    public function filter()
    {
        $category_id = $_GET['category'] ?? null; // Get the category ID from the AJAX request

        // Log the received category ID
        error_log("Received category ID: " . $category_id);

        // If a category is selected, filter products by that category
        if ($category_id) {
            $products = $this->productModel->getProductsByCategory($category_id);
        } else {
            // If no category is selected, return all products
            $products = $this->productModel->getAllProducts();
        }

        // Process the filtered products
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        // Log the response
        error_log("Filtered products: " . json_encode($products));

        // Return the JSON response for the filtered products
        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }



    public function edit($id)
    {
        // Fetch the product by ID
        $product = $this->productModel->getProductByID($id);

        // Fetch all categories for the dropdown
        $categories = $this->categoryModel->getAllCategories();

        // Check if the product exists
        if ($product) {
            // Render the edit view with the product and categories data
            $this->view("inventory/edit", ['product' => $product, 'categories' => $categories]);
        } else {
            // If the product is not found, set an error message and redirect
            $_SESSION['error'] = "Product not found!";
            $this->redirect("/inventory/products");
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $expire_date = $_POST['expire_date'] ?? '';
            $original_price = $_POST['original_price'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $stocks = $_POST['stocks'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $status = $_POST['status'] ?? 'instock';

            // Handle image upload or set default image
            $imagePath = isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0
                ? $this->uploadImage($_FILES['productImage'])
                : 'uploads/default-image.jpg'; // Default image path

            if (empty($name) || empty($price) || empty($category_id)) {
                $_SESSION['error'] = "Please fill all required fields.";
                $this->redirect("/inventory/products/create");
                return;
            }

            $data = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'expire_date' => $expire_date,
                'original_price' => $original_price, // Ensure this is passed
                'category_id' => $category_id,
                'stocks' => $stocks,
                'status' => $status,
                'start_date' => $start_date,
                'image' => $imagePath
            ];

            // Log the data for debugging
            error_log("Data passed to storeProduct: " . json_encode($data));

            if ($this->productModel->storeProduct($data)) {
                $_SESSION['success'] = "Product added successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to add product.";
                $this->redirect("/inventory/products/create");
            }
        }
    }
   


    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $expire_date = $_POST['expire_date'] ?? '';
            $original_price = $_POST['original_price'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $stocks = $_POST['stocks'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $status = $_POST['status'] ?? 'instock';

            // Fetch the existing product to retain the current image if no new image is uploaded
            $existingProduct = $this->productModel->getProductByID($id);
            if (!$existingProduct) {
                $_SESSION['error'] = "Product not found!";
                $this->redirect("/inventory/products");
                return;
            }

            $imagePath = $existingProduct['image']; // Default to existing image
            if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
                $uploadedImage = $this->uploadImage($_FILES['productImage']);
                if ($uploadedImage) {
                    $imagePath = $uploadedImage;
                } else {
                    $_SESSION['error'] = "Failed to upload image.";
                    $this->redirect("/inventory/edit/$id");
                    return;
                }
            }

            // Validate required fields
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
                'expire_date' => $expire_date,
                'original_price' => $original_price,
                'category_id' => $category_id,
                'stocks' => $stocks,
                'status' => $status,
                'start_date' => $start_date,
                'image' => $imagePath
            ];

            // Attempt to update the product
            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success'] = "Product updated successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to update product.";
                $this->redirect("/inventory/edit/$id");
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete product.";
        }
        header("Location: /inventory/products");
        exit;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? ''; 
            $expire_date = $_POST['expire_date'] ?? '';
            $original_price = $_POST['original_price'] ?? '';
            $stocks = $_POST['stocks'];
            $start_date = $_POST['start_date'] ?? '';
            $category_id = $_POST['category_id'];
            $price = $_POST['price'] ?? '';
            $expire_date = $_POST['expire_date'] ?? '';
            $stocks = $_POST['stocks'] ?? '';
            $start_date = $_POST['start_date'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $status = $_POST['status'] ?? 'in-stock';

            // Handle image upload
            $imagePath = isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0
                ? $this->uploadImage($_FILES['productImage'])
                : 'uploads/default-image.jpg';

            // Log the data being passed to the model
            error_log("Product Data: " . json_encode([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'expire_date' => $expire_date,
                'original_price' => $original_price,
                'stocks' => $stocks,
                'category_id' => $category_id,
                'status' => $status,
                'start_date' => $start_date,
                'image' => $imagePath
            ]));

            $data = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'expire_date' => $expire_date,
                'original_price' => $original_price,
                'stocks' => $stocks,
                'category_id' => $category_id,
                'status' => $status,
                'start_date' => $start_date,
                'image' => $imagePath
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


    private function uploadImage($file)
    {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);
    
        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    
        // Validate the file is an image
        if (isset($file['tmp_name']) && getimagesize($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                return $uploadFile; // Return the image path
            }
        }
    
        return false; // Return false if upload fails
    }

    private function getImageUrl($imagePath)
    {
        $defaultImage = '/uploads/default-image.jpg'; // Ensure this file exists
        if (!empty($imagePath) && file_exists($imagePath)) {
            return '/' . $imagePath;
        }
        return $defaultImage;
    }

    public function getProductsByCategory($categoryId)
    {
        $products = $this->productModel->getProductsByCategoryId($categoryId);
        $categories = $this->categoryModel->getAllCategories();
        $this->view('inventory/product', ['products' => $products, 'categories' => $categories]);
    }
}
