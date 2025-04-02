<?php

require_once "Models/UserModel.php";

class UserController extends BaseController {

    private $users;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->users = new UserModel();

        // Exclude certain methods from authentication check
        $currentMethod = $_GET['action'] ?? 'index'; // Assuming 'action' is used to determine the method
        $excludedMethods = ['signIn', 'authenticate'];

        if (!in_array($currentMethod, $excludedMethods) && (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))) {
            header("Location: /users/signIn");
            exit();
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and authenticate user
            // For example:
            $username = $_POST['username'];
            $password = $_POST['password'];
            // Check credentials and set session
            $_SESSION['user_id'] = 1; // Example user ID
            $this->redirect('/dashboard/sell');
        } else {
            $this->signIn(); // Call the signIn method directly
        }
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
        // Ensure no redirection to dashboard if session is cleared
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $this->view('/users/signIn'); // Render the sign-in view
        } else {
            $this->redirect("/dashboard/sell"); // Redirect only if user is logged in
        }
    }
}
?>
