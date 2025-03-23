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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST['sales'];
        if (is_array($data)) {
            foreach ($data as $prod) {
                $decodedProduct = json_decode($prod, true);
                $productId = $decodedProduct['product_id'];
                $quantity = $decodedProduct['quantity'];
                $updatedStock = $decodedProduct['updated_stock']; // Get updated stock

                // Get product from the database to check current stock
                $product = $this->productModel->getProductById($productId);

                // Calculate the total price for the sale item
                $saleItemData = [
                    'sale_id' => 1, // Replace with the actual sale ID
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product['price'] * $quantity
                ];

                // Create sale item
                if ($this->salesModel->create($saleItemData)) {
                    // Update product quantity after successful sale
                    $newQuantity = $product['stocks'] - $quantity;

                    // Ensure stock doesn't go below 0
                    if ($newQuantity < 0) {
                        $newQuantity = 0; // Or handle this scenario as needed
                    }

                    // Prepare the updated product
                    $newProduct = [
                        'stocks' => $updatedStock // Use updated stock from frontend
                    ];

                    // Update the product stock in the database
                    $this->productModel->updateProduct($productId, $newProduct);
                } else {
                    // Handle creation failure
                    throw new Exception("Failed to create sale record");
                }
            }

            // Redirect to sales page after successful sale
            $this->redirect('/sales');
        }
    }
}

    



}