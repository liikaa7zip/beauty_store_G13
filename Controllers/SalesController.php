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
                $decodedProduct = json_decode($prod, true);
                $productId = $decodedProduct['product_id'];
                $quantity = $decodedProduct['quantity'];
                $product = $this->productModel->getProductById($productId);

                if (!$product) {
                    throw new Exception("Product not found.");
                }

                if ($product['stocks'] < $quantity) {
                    throw new Exception("Not enough stock for product ID: " . $productId);
                }

                $saleItemData = [
                    'sale_id' => 1, // Replace with actual sale ID
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product['price'] * $quantity
                ];

                if ($this->salesModel->create($saleItemData)) {
                    // Update stock only if sale is successful
                    $newQuantity = $product['stocks'] - $quantity;
                    $this->productModel->updateProduct($productId, ['stocks' => $newQuantity]);
                } else {
                    throw new Exception("Failed to create sale record");
                }
            }
        }
        $this->redirect('/sales'); // Move this outside the loop
    }
}

}