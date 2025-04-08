<?php

require_once "Models/EmployeesModel.php";
require_once 'BaseController.php';

class EmployeeController extends BaseController
{
    private $employeesModel;

    public function __construct()
    {
        $this->employeesModel = new EmployeesModel();
    }
    public function index()
    {
        if ($_SESSION['role'] === 'staff') {
           
            $this->redirect('/dashboard');
            exit;
        }

        $employees = $this->employeesModel->getAllEmployees();
        $currentUser = [
            'role' => $_SESSION['role'] ?? 'unknown',
            'username' => $_SESSION['user_name'] ?? 'unknown'
        ];
        $this->view('employees/employees', [
            'employees' => $employees,
            'currentUser' => $currentUser
        ]);
    }
    public function create()
    {
        // Render the create employee form
        $this->view('employees/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $role = htmlspecialchars($_POST['role']);
            $image = 'https://cdn-icons-png.flaticon.com/512/149/149071.png'; // Default image

            // Handle image upload if provided
            if (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleUpload();
                if ($uploadedImage) {
                    $image = '/uploads/' . $uploadedImage;
                }
            }

            // Prepare data for insertion
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'image' => $image
            ];

            // Save the employee to the database
            $this->employeesModel->createUser($data);

            // Redirect to the employees list
            $this->redirect('/employees');
        }
    }

    private function handleUpload()
    {
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExt;
            $uploadDir = 'uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $destPath = $uploadDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                return $newFileName;
            }
        }
        return false;
    }

    public function destroy($id)
    {
        // Delete the employee from the database
        $this->employeesModel->deleteUser($id);

        // Redirect to the employees list
        $this->redirect('/employees');
    }
    public function edit($id)
    {
        // Fetch employee data for editing
        $employee = $this->employeesModel->getUserById($id);

        // Pass employee data to the view
        $this->view('employees/edit', ['employee' => $employee]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $role = htmlspecialchars($_POST['role']);
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

            // Handle image upload if provided
            $image = $this->employeesModel->getUserById($id)['image']; // Keep current image by default
            if (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleUpload();
                if ($uploadedImage) {
                    $image = '/uploads/' . $uploadedImage;
                }
            }

            // Prepare data for update
            $data = [
                'id' => $id,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'image' => $image
            ];

            // Update the employee in the database
            $this->employeesModel->updateUser($data);

            // Redirect to the employees list
            $this->redirect('/employees');
        }
    }
}
