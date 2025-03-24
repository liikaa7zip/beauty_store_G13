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

    public function login()
    {
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

    public function logout()
    {
        // Implement the logout logic here
        session_destroy();
        $this->redirect('/users/signIn');
    }

    // Authenticate user (SignIn)
    public function authenticate() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error'] = "Email and password are required.";
            $this->redirect("/users/signIn");
            return;
        }

        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $user = $this->users->getUserByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_name'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['success'] = "Welcome back, " . $user['username'];
            $this->redirect("/dashboard/sell");
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            $this->redirect("/users/signIn");
        }
    }

    // SignIn page view
    public function signIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            $this->redirect("/dashboard/sell");
        } else {
            // Check for any errors in session
            $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
            $this->view('/users/signIn', ['error' => $error]);
        }
    }

}
?>
