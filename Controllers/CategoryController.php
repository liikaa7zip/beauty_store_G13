<?php
require_once 'BaseController.php';
require_once 'Models/HistoryModel.php';
require_once 'Models/CategoryModel.php';
class CategoryController extends BaseController
{
    private $categoryModel;
    private $productModel;
    private $historyModel;

    public function __construct($db)
    {
        $this->categoryModel = new CategoryModel($db);
        $this->productModel = new ProductModel($db);
        $this->historyModel = new HistoryModel(); // Initialize the HistoryModel
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->view('categories/categories', ['categories' => $categories]);
    }

    public function create()
    {
        $this->view('categories/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['category_name']) && isset($_POST['category_description'])) {
                $category_name = trim($_POST['category_name']);
                $category_description = trim($_POST['category_description']);
                $userId = $_SESSION['user_id'] ?? null; // Get the logged-in user ID
    
                if (!empty($category_name) && !empty($category_description)) {
                    $result = $this->categoryModel->createCategories($category_name, $category_description);
                    if ($result) {
                        // Log the action to category_history
                        $this->historyModel->logCategoryAction($category_name, 'add', $userId);
                        $this->redirect('/categories');
                    } else {
                        echo "Error inserting data into the database.";
                    }
                } else {
                    echo "Both category name and description are required.";
                }
            } else {
                echo "Invalid form submission.";
            }
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            $this->view('categories/edit', ['category' => $category]);
        } else {
            echo "Category not found.";
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_name = trim($_POST['category_name']);
            $category_description = trim($_POST['category_description']);
            $userId = $_SESSION['user_id'] ?? null; // Get the logged-in user ID
    
            if (!empty($category_name) && !empty($category_description)) {
                $result = $this->categoryModel->updateCategory($id, $category_name, $category_description);
                if ($result) {
                    // Log the action to category_history
                    $this->historyModel->logCategoryAction($category_name, 'update', $userId);
                    $this->redirect('/categories');
                } else {
                    echo "Error updating category.";
                }
            } else {
                echo "Both category name and description are required.";
            }
        }
    }

    public function delete($id)
    {
        $categoryName = $this->categoryModel->getCategoryNameById($id);
        $userId = $_SESSION['user_id'] ?? null; // Get the logged-in user ID
    
        $result = $this->categoryModel->deleteCategoryById($id);
        if ($result) {
            // Log the action to category_history
            $this->historyModel->logCategoryAction($categoryName, 'delete', $userId);
            $this->redirect('/categories');
        } else {
            echo "Error deleting category.";
        }
    }
    public function clearForm()
    {
        $_POST = [];
    }
}
