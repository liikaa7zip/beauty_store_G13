<?php

require_once "Models/SalesModel.php";

class SalesController extends BaseController
{
    private $salesModel;

    public function __construct()
    {
        $this->salesModel = new SalesModel();
    }

    public function index()
    {
        // Fetch sales data from the database
        $sales = $this->salesModel->getAllSales();
        
        // Pass sales data to the view
        $this->view('/sales/sales', ['sales' => $sales]);
    }
}
?>