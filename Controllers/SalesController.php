<?php
require_once 'Models/SalesModel.php';

class SalesController extends BaseController{

    public function index()
    {
        $this->view("/sales/sales");
    }

// require_once "views/layouts/navbar.php";
// require_once "views/layouts/header.php";
// require_once "views/layouts/sidebar.php";
// class SalesController {
    private $model;

    public function __construct() {
        $this->model = new SalesModel();
    }

    // public function index() {
    //     $popularProducts = $this->getPopularProducts();
    //     $salesData = $this->getSalesData();
    //     $stockData = $this->getStockData();

    //     echo "<h1>Sales Dashboard</h1>";
    //     echo "<h2>Popular Products:</h2><pre>" . print_r($popularProducts, true) . "</pre>";
    //     echo "<h2>Sales Data:</h2><pre>" . print_r($salesData, true) . "</pre>";
    //     echo "<h2>Stock Data:</h2><pre>" . print_r($stockData, true) . "</pre>";
    // }

    public function getPopularProducts() {
        return $this->model->getProducts();
    }

    public function getSalesData() {
        $sales = $this->model->getSales();
        return [
            'total' => array_sum($sales),
            'monthly' => $sales,
            'period' => 'Jan-June 2023'
        ];
    }

    public function getStockData() {
        return $this->model->getStockLevels();
    }
}
// require_once "views/layouts/footer.php";