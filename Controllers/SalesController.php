<?php

require_once "Models/SalesModel.php";
require_once "Models/ProductModel.php";
require_once "Models/SellModel.php";

class SalesController extends BaseController
{
    private $productModel;
    private $salesModel;
    private $sellModel;
    private $customerModel; 

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
            $customerId = $_POST['customer_id']; // Assuming you're passing customer_id with the sale
    
            // Process sale data
            if (is_array($data)) {
                foreach ($data as $prod) {
                    $decodedProduct = json_decode($prod, true);
                    $productId = $decodedProduct['product_id'];
                    $quantity = $decodedProduct['quantity'];
                    $product = $this->productModel->getProductByID($productId);
    
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
                'sale_date' => date('Y-m-d H:i:s'),
                'total_amount' => $totalAmount,
            ]);
    
            // Handle customer debt update
            if ($customerId) {
                $customer = $this->customerModel->getCustomerById($customerId);
                $remainingDebt = $customer['total_debt'];
    
                // Update the debt (subtract the total amount of the sale)
                $newDebt = $remainingDebt + $totalAmount;
    
                // Update the customer's debt
                $this->customerModel->updateCustomerDebt($customerId, $newDebt);
            }
    
            // Store sale items and update stock
            foreach ($saleItems as &$item) {
                $item['sale_id'] = $sale['id'];
                $this->salesModel->create($item);
    
                // Update product stock
                $product = $this->productModel->getProductByID($item['product_id']);
                $newStock = $product['stocks'] - $item['quantity'];
    
                // Ensure stock is not negative
                if ($newStock < 0) {
                    $_SESSION['error'] = "Insufficient stock for product ID: {$item['product_id']}";
                    $this->redirect('/sales');
                    return;
                }
    
                $this->productModel->updateProduct($item['product_id'], ['stocks' => $newStock]);
    
                // Insert into sell_history
                $this->salesModel->insertSellHistory([
                    'sale_id' => $sale['id'],
                    'product_name' => $product['name'],
                    'amount' => $item['price'],
                    'quantity' => $item['quantity'],
                    'performed_by' => $_SESSION['user_id'], // Assuming the logged-in user's ID is stored in the session
                    'sale_date' => $sale['sale_date'],
                ]);
            }
    
            $this->redirect('/sales');
        }
    }

    
}