<?php

// class BaseController
// {
//     /**
//      * Helper function to render a view.
//      *
//      * @param string $view The view file to render.
//      * @param array $data The data to pass to the view.
//      */
//     protected function view($viewPath, $data = [])
//     {
//         // Ensure $employees is defined
//         if (!isset($data['employees'])) {
//             $data['employees'] = [];
//         }

//         extract($data);
//         ob_start(); // Start output buffering
//         require_once __DIR__ . '/../views/' . $viewPath . '.php';
//         $content = ob_get_clean();
//         require "views/layout.php";
//         ob_end_flush(); // Flush the output buffer
//     }

//     /**
//      * Helper function to handle redirections.
//      *
//      * @param string $url The URL to redirect to.
//      */
//     protected function redirect($url)
//     {
//         ob_start(); // Start output buffering
//         header("Location: $url");
//         ob_end_flush(); // Flush the output buffer
//         exit;
//     }
// }


            //Test code1  working--------------------------------------------------------------
class BaseController {
    protected function view($viewPath, $data = []) {
        if (!isset($data['employees'])) {
            $data['employees'] = [];
        }
        $viewFile = __DIR__ . '/../views/' . trim($viewPath, '/') . '.php';
        if (!file_exists($viewFile)) {
            die("Error: View file not found at: " . $viewFile);
        }
        extract($data);
        ob_start();
        require_once $viewFile;
        $content = ob_get_clean();
        $layoutFile = __DIR__ . '/../views/layout.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            die("Error: Layout file not found at: " . $layoutFile);
        }
        ob_end_flush();
    }
    protected function redirect($url) {
        ob_start();
        header("Location: $url");
        ob_end_flush();
        exit;
    }
}

//Test code2--------------------------------------------------------------

// class EmployeesModel {
//     private $db;

//     public function __construct() {
//         $database = new Database();
//         $this->db = $database->getConnection();
//     }

//     public function addEmployee($username, $role, $contact, $status, $email, $password, $imagePath) {
//         try {
//             $stmt = $this->db->prepare("
//                 INSERT INTO employees (username, role, contact, status, email, password, image_path, created_at)
//                 VALUES (:username, :role, :contact, :status, :email, :password, :image_path, NOW())
//             ");
//             $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//             $stmt->execute([
//                 ':username' => $username,
//                 ':role' => $role,
//                 ':contact' => $contact,
//                 ':status' => $status,
//                 ':email' => $email,
//                 ':password' => $hashedPassword,
//                 ':image_path' => $imagePath
//             ]);
//             return true;
//         } catch (PDOException $e) {
//             // Log the error in production; for now, display for debugging
//             echo "DB Error: " . $e->getMessage();
//             return false;
//         }
//     }

//     public function getAllEmployees() {
//         try {
//             $stmt = $this->db->prepare("SELECT * FROM employees");
//             $stmt->execute();
//             return $stmt->fetchAll(PDO::FETCH_ASSOC);
//         } catch (PDOException $e) {
//             echo "DB Error: " . $e->getMessage();
//             return [];
//         }
//     }
// }


    
?>