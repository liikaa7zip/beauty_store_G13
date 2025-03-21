<?php
require_once "Models/ExportModel.php";
require_once "Models/CategoryModel.php";

class ExportController extends BaseController {
    private $exportModel;
    private $categoryModel;

    public function __construct() {
        $this->exportModel = new ExportModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $products = $this->exportModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }
        $this->view("inventory/export", ['products' => $products]);
    }

    public function export() {
        $products = $this->exportModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }

        $data = [];
        $data[] = ['ID', 'Name', 'Description', 'Price', 'Category ID', 'Stocks', 'Status', 'Category Name'];
        foreach ($products as $product) {
            $data[] = [
                $product['id'],
                $product['name'],
                $product['description'],
                $product['price'],
                $product['category_id'],
                $product['stocks'],
                $product['status'],
                $product['category_name']
            ];
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="products_export.xls"');
        header('Cache-Control: max-age=0');

        $output = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row, "\t");
        }
        fclose($output);
        exit;
    }
}
?>