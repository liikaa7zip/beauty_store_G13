<?php 

    require_once "Models/EmployeesModel.php";
    require_once 'BaseController.php';

    

    class EmployeeController extends BaseController 
{
    private $employeesModel;

    public function __construct() {
        $this->employeesModel = new EmployeesModel();
    }

    public function index() {
        // Fetch employees from the database
        $employees = $this->employeesModel->getAllEmployees();
        
        // Pass employees data to the view
        $this->view('employees/employees', ['employees' => $employees]);
    }

    public function add() {
        $data = [];
        $this->view('employees/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : null;
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;
            $role = isset($_POST['role']) ? htmlspecialchars($_POST['role']) : null;
            $contact = "N/A";
            $status = "Active";

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $this->view('employees/create', ['error' => 'All fields are required.']);
                return;
            }

            // Pass data to addEmployee
            $result = $this->employeesModel->addEmployee($username, $role, $contact, $status, $email, $password);

            if ($result) {
                header("Location: /employees");
                exit();
            } else {
                $this->view('employees/addemployees', ['error' => 'Failed to add employee.']);
            }
        } else {
            header("Location: /employees/add");
            exit();
        }
    }
    public function create() {
        $this->view('employees/create');
}
}

//---------------------------------//Test code1 --------------------------------------------------------------



?>