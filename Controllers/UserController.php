<?php

require_once "Models/UserModel.php";

class UserController extends BaseController {

    private $users;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->users = new UserModel();
    }

    public function login() {
        // Implement the login logic here
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and authenticate user
            // For example:
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Check credentials and set session
            $_SESSION['user_id'] = 1; // Example user ID
            $this->redirect('/dashboard/sell');
        } else {
            $this->view('/users/signIn');
        }
    }

    public function logout() {
        // Implement the logout logic here
        session_destroy();
        $this->redirect('/users/signIn');
    }

    // Authenticate user (SignIn)
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate credentials (example logic)
            $user = $this->users->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['username'];
                $this->redirect("/dashboard/sell");
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                $this->redirect("/users/signIn");
            }
        }
    }

    // SignIn page view
    public function signIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            // Redirect authenticated users to the dashboard
            $this->redirect("/dashboard/sell");
        } else {
            // Render the sign-in view for unauthenticated users
            $this->view('/users/signIn');
        }
    }
}
?>
