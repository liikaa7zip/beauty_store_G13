<?php

require_once "Models/SalesModel.php";
require_once "Models/ProductModel.php";
require_once "Models/SellModel.php";

class SalesController extends BaseController
{
    private $productModel;
    private $salesModel;
    private $sellModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
        $this->productModel = new ProductModel();
        $this->sellModel = new SellModel();
    }

    public function index()
    {
        // Fetch sales data from the database
        $sales = $this->salesModel->getAllSales();
        $products = $this->productModel->getAllProducts();

        // Pass sales data to the view
        return $this->view('/sales/sales', ['sales' => $sales, 'products' => $products]);
    }
    
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST['sales'];
            $totalAmount = 0;
            $saleItems = [];

            if (is_array($data)) {
                foreach ($data as $prod) {
                    $decodedProduct = json_decode($prod, true);
                    $productId = $decodedProduct['product_id'];
                    $quantity = $decodedProduct['quantity'];
                    $product = $this->productModel->getProductByID($productId);

                    // Log product details for debugging
                    error_log("Product ID: $productId, Current Stock: {$product['stocks']}, Quantity Sold: $quantity");

                    // Calculate total amount for the sale
                    $totalAmount += $product['price'] * $quantity;

                    $saleItemData = [
                        'sale_id' => null, // Sale ID will be set after creating the sale
                        'product_id' => $productId,
                        'price' => $product['price'] * $quantity,
                        'quantity' => $quantity,
                    ];

                    // Store sale item data temporarily
                    $saleItems[] = $saleItemData;
                }
            }

            // Create the sale record
            $sale = $this->sellModel->create([
                'sale_date' => date('Y-m-d'),
                'total_amount' => $totalAmount,
            ]);

            // Use the created sale ID to store sale items
            foreach ($saleItems as &$item) {
                $item['sale_id'] = $sale['id'];
                $this->salesModel->create($item);

                // Update product stock
                $product = $this->productModel->getProductByID($item['product_id']);
                $newStock = $product['stocks'] - $item['quantity'];

                // Log stock update details for debugging
                error_log("Updating Product ID: {$item['product_id']}, New Stock: $newStock");

                // Ensure stock is not negative
                if ($newStock < 0) {
                    $_SESSION['error'] = "Insufficient stock for product ID: {$item['product_id']}";
                    $this->redirect('/sales');
                    return;
                }

                $this->productModel->updateProduct($item['product_id'], ['stocks' => $newStock]);
            }

            $this->redirect('/sales');
        }
    }
}