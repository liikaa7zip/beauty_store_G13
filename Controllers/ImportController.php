<?php
require_once "Models/ImportModel.php";
require_once "Models/CategoryModel.php";

class ImportController extends BaseController {
    private $importModel;
    private $categoryModel;

    public function __construct() {
        $this->importModel = new ImportModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $products = $this->importModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }
        $this->view("inventory/import", ['products' => $products]);
    }

    public function export() {
        $products = $this->importModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }

        $data = [];
        $data[] = ['Name', 'Stock', 'Category', 'Status'];
        foreach ($products as $product) {
            $data[] = [
                $product['name'],
                $product['stocks'],
                $product['category_name'],
                $product['status']
            ];
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="products_export.csv"');
        header('Cache-Control: max-age=0');

        $output = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }

    public function import() {
        error_log("Import endpoint reached");
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $file = $_FILES['file']['tmp_name'];

            $fileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (strtolower($fileExtension) !== 'csv') {
                echo json_encode(['success' => false, 'message' => 'Only CSV files are supported']);
                exit;
            }

            try {
                $handle = fopen($file, 'r');
                if ($handle === false) {
                    throw new Exception('Failed to open file');
                }

                $headers = fgetcsv($handle);
                $expectedHeaders = ['Name', 'Stock', 'Category', 'Status'];

                if (array_slice($headers, 0, 4) !== $expectedHeaders) {
                    fclose($handle);
                    echo json_encode(['success' => false, 'message' => 'Invalid headers']);
                    exit;
                }

                while (($row = fgetcsv($handle)) !== false) {
                    if (empty($row[0])) continue;
                    $name = $row[0];
                    $stock = $row[1];
                    $category = $row[2];
                    $status = $row[3];

                    $categoryId = $this->categoryModel->getCategoryIdByName($category);
                    if (!$categoryId) {
                        continue;
                    }

                    $this->importModel->insertOrUpdateProduct([
                        'name' => $name,
                        'stocks' => $stock,
                        'category_id' => $categoryId,
                        'status' => $status
                    ]);
                }

                fclose($handle);
                echo json_encode(['success' => true, 'message' => 'Import successful']);
            } catch (Exception $e) {
                if (isset($handle) && is_resource($handle)) {
                    fclose($handle);
                }
                echo json_encode(['success' => false, 'message' => 'Import failed: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        }
        exit;
    }

    public function data() {
        $products = $this->importModel->getAllProducts();
        foreach ($products as &$product) {
            $product['category_name'] = $this->categoryModel->getCategoryNameById($product['category_id']);
        }
        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }
}
?>