<?php
require_once "Models/ProductModel.php";
require_once "Models/CategoryModel.php";
require_once "Models/HistoryModel.php";

class ProductsController extends BaseController
{
    private $productModel;
    private $categoryModel;
    private $historyModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->historyModel = new HistoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $products = $this->productModel->getAllProducts();

        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        $this->view("inventory/products", ['products' => $products, 'categories' => $categories]);
    }


    public function filter()
    {
        $category_id = $_GET['category'] ?? null;

        if ($category_id) {
            $products = $this->productModel->getProductsByCategory($category_id);
        } else {
            $products = $this->productModel->getAllProducts();
        }

        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductByID($id);
        $categories = $this->categoryModel->getAllCategories();

        if ($product) {
            $this->view("inventory/edit", ['product' => $product, 'categories' => $categories]);
        } else {
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

            $imagePath = isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0
                ? $this->uploadImage($_FILES['productImage'])
                : 'uploads/default-image.jpg';

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
                $userId = $_SESSION['user_id'] ?? null;
                $this->historyModel->logProductAction($name, 'created', $userId);

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

            $existingProduct = $this->productModel->getProductByID($id);
            if (!$existingProduct) {
                $_SESSION['error'] = "Product not found!";
                $this->redirect("/inventory/products");
                return;
            }

            $imagePath = $existingProduct['image'];
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

            if (empty($name) || empty($price) || empty($category_id)) {
                $_SESSION['error'] = "Please fill all required fields.";
                $this->redirect("/inventory/edit/$id");
                return;
            }

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

            if ($this->productModel->updateProduct($id, $data)) {
                $userId = $_SESSION['user_id'] ?? null;
                $this->historyModel->logProductAction($name, 'updated', $userId);

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
        $product = $this->productModel->getProductByID($id);
        if ($this->productModel->deleteProduct($id)) {
            $userId = $_SESSION['user_id'] ?? null;
            $this->historyModel->logProductAction($product['name'], 'deleted', $userId);

            $_SESSION['success'] = "Product deleted successfully!";
        } else {
            $_SESSION['error'] = "Failed to delete product.";
        }
        $this->redirect("/inventory/products");
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
                $userId = $_SESSION['user_id'] ?? null;
                $this->historyModel->logProductAction($name, 'created', $userId);

                $_SESSION['success'] = "Product created successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to create product.";
                $this->redirect("/inventory/products/create");
            }
        }

        $categories = $this->categoryModel->getAllCategories();
        $this->view("inventory/create", ['categories' => $categories]);
    }


    private function uploadImage($file)
    {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (isset($file['tmp_name']) && getimagesize($file['tmp_name'])) {
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                return $uploadFile;
            }
        }

        return false;
    }

    private function getImageUrl($imagePath)
    {
        $defaultImage = '/uploads/default-image.jpg';
        if (!empty($imagePath) && file_exists($imagePath)) {
            return '/' . $imagePath;
        }
        return $defaultImage;
    }

    public function getProductsByCategory($category_id)
    {
        $products = $this->productModel->getProductsByCategory($category_id);
        $categories = $this->categoryModel->getAllCategories();

        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
            $product['image'] = $this->getImageUrl($product['image']);
            $product['formatted_price'] = '$' . number_format($product['price'], 2);
        }

        $this->view("inventory/product", ['products' => $products, 'categories' => $categories]);
    }
}
