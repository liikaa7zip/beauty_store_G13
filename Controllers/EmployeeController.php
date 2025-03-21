<?php 

    require_once "Models/EmployeesModel.php";

    class EmployeeController extends BaseController 
    {
        private $employeesModel;
        public function __construct() {
            $this->employeesModel = new EmployeesModel();
        }
        public function index(){
            // Fetch employees from the database
            $employees = $this->employeesModel->getAllEmployees();
            
            // Pass employees data to the view
            $this->view('/employees/employees', ['employees' => $employees]);
        }

    }
?>