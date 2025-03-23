<?php

require_once "Models/SalesModel.php";
require_once "Models/ProductModel.php";

class SalesController extends BaseController
{
    private $productModel;
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
        $this->productModel = new ProductModel();
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
       if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $data = $_POST['sales'];
            if (is_array($data)) {
                foreach ($data as $prod) {
                    // Get product price
                    $decodedProduct = json_decode($prod, true);
                    $productId = $decodedProduct['product_id'];
                    $quantity = $decodedProduct['quantity'];
                    $product = $this->productModel->getProductById($productId);
                    
                    $saleItemData = [
                        'sale_id' => 1, // Replace with the actual sale ID
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $product['price'] * $quantity
                    ];                    
                    // Create sale item
                    if ($this->salesModel->create($saleItemData)) {
                        // Update product quantity after successful sale
                        $currentQuantity = $product['stocks'];
                        $newQuantity = $currentQuantity - $quantity;
                        $newProduct = [
                            ...$product,
                            'stocks' => $newQuantity
                        ];
                        $this->productModel->updateProduct($productId, $newProduct);
                    } else {
                        // Handle creation failure
                        
                        throw new Exception("Failed to create sale record");
                    }
                    $this->redirect('/sales');
                }
            }
        }
        // Return success response
    }
}