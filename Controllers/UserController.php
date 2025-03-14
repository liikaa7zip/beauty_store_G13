<?php 

require_once "Models/UserModel.php";

class UserController extends BaseController {

    private $users;

    public function __construct() {
        $this->users = new UserModel();
    }

    // Login page view
    public function login() {
        session_start(); // This can be moved to a centralized location like BaseController
        session_destroy();
        $this->view('users/signUp');
    }

    // Store new user (SignUp)
    public function store() {
        session_start();
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
            $_SESSION['error'] = "All fields are required.";
            $this->redirect("/users/signUp");
            return;
        }

        $username = htmlentities($_POST['username']);
        $email = htmlentities($_POST['email']);
        $password = htmlentities($_POST['password']);
        $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
        $role = htmlentities($_POST['role']);
        
        if ($this->users->getUserByUsername($username)) {
            $_SESSION['error'] = "Username already exists.";
            $this->redirect("/users/signUp");
            return;
        }

        if ($this->users->getUserByEmail($email)) {
            $_SESSION['error'] = "Email already exists.";
            $this->redirect("/users/signUp");
            return;
        }
        
        // Create the user and redirect
        $this->users->createUser($username, $email, $encrypted_password, $role);
        $_SESSION['success'] = "Account created successfully!";
        $this->redirect("/dashboard/sell");
    }

    // Authenticate user (SignIn)
    public function authenticate() {
        session_start();
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
        if (isset($_SESSION['user_id'])) {
            $this->redirect("/dashboard/sell");
        } else {
            // Check for any errors in session
            $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
            $this->view('users/signIn', ['error' => $error]);
        }
    }
}

?>
