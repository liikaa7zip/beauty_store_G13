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



    public function edit($id) {
        $product = $this->products->getProductByID($id);
    
        if ($product) {
            $this->view("inventory/edit", ['product' => $product]);
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
            if ($this->products->storeProduct($data)) {
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
            if ($this->products->updateProduct($id, $data)) {
                $_SESSION['success'] = "Product updated successfully!";
                $this->redirect("/inventory/products");
            } else {
                $_SESSION['error'] = "Failed to update product.";
                $this->redirect("/inventory/edit/$id");
            }
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
