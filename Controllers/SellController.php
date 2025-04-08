<?php
require_once "Models/ProductModel.php";
require_once "Models/SalesModel.php";
require_once "Models/EmployeesModel.php";
class SellController extends BaseController
{

    private $productModel;
    private $salesModel;
    private $userModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->salesModel = new salesModel();
        $this->userModel = new EmployeesModel();
    }

    public function index()
    {
        $month = isset($_GET['month']) ? (int) $_GET['month'] : date('m'); // Default to current month
        $year = isset($_GET['year']) ? (int) $_GET['year'] : date('Y'); // Default to current year

        $products = $this->productModel->getAllProducts();
        $sells = $this->salesModel->getAllSales();
        $sellsProd = $this->salesModel->getTotalProductSell($month, $year); // Pass month & year
        $users = $this->userModel->getAllEmployees();
        $past7Day = $this->salesModel->getSallesLastWeeks();
        $sale = $this->salesModel->getAllSales(); // Fetch sales data

        $this->view("/dashboard/sell", [
            'products' => $products,
            'sells' => $sells,
            'users' => $users,
            'lastSales' => $past7Day,
            'sellsProd' => $sellsProd,
            'selectedMonth' => $month,
            'selectedYear' => $year,
            'sale' => $sale
        ]);
    }

}