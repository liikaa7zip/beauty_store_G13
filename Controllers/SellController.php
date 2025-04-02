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
        $products = $this->productModel->getAllProducts();
        $sells = $this->salesModel->getAllSales();
        $sellsProd = $this->salesModel->getTotalProductSell();
        $users = $this->userModel->getAllEmployees();
        $past7Day = $this->salesModel->getSallesLastWeeks();
        $this->view("/dashboard/sell", ['products' => $products, 'sells' => $sells, 'users' => $users, 'lastSales' => $past7Day, 'sellsProd' => $sellsProd]);
    }
}