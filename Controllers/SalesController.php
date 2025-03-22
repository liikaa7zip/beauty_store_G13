<?php

require_once "Models/SalesModel.php";
require_once "Models/ProductModel.php";

class SalesController extends BaseController
{
    private $ProductModel;
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
        $this->ProductModel = new ProductModel();
    }

    public function index()
    {
        // Fetch sales data from the database
        $sales = $this->salesModel->getAllSales();
        $products = $this->ProductModel->getAllProducts();


        // Pass sales data to the view
        return $this->view('/sales/sales', ['sales' => $sales, 'products' => $products]);
    }
    public function store()
    {
        return $this->view('/sales/create');
    }
}