<?php

require_once "Models/UserModel.php";
require_once "Controllers/HistoryController.php";

class UserController extends BaseController
{
    private $users;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->users = new UserModel();

        // Exclude certain methods from authentication check
        $currentMethod = $_GET['action'] ?? 'index'; // Assuming 'action' is used to determine the method
        $excludedMethods = ['signIn', 'authenticate'];

        if (!in_array($currentMethod, $excludedMethods) && (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))) {
            if ($_SERVER['REQUEST_URI'] !== '/users/signIn') { // Prevent redirect loop
                header("Location: /users/signIn");
                exit();
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                $user = $this->users->getUserByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['username'];

                    // Ensure logLogin is called only once
                    $historyController = new HistoryController();
                    $historyController->logLogin(
                        $user['id'],
                        $_SERVER['REMOTE_ADDR'],
                        $_SERVER['HTTP_USER_AGENT'],
                        'success'
                    );

                    $this->redirect("/dashboard/sell");
                } else {
                    $historyController = new HistoryController();
                    $historyController->logLogin(
                        0,
                        $_SERVER['REMOTE_ADDR'],
                        $_SERVER['HTTP_USER_AGENT'],
                        'failed'
                    );

                    $_SESSION['error'] = "Invalid email or password.";
                    $this->redirect("/users/signIn");
                }
            } else {
                $_SESSION['error'] = "Please fill in all fields.";
                $this->redirect("/users/signIn");
            }
        } else {
            $this->signIn(); // Call the signIn method directly
        }
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $historyController = new HistoryController();
            $historyController->logLogout($_SESSION['user_id']);
        }

        session_unset();
        session_destroy();

        header("Location: /users/signIn");
        exit;
    }

    // Authenticate user (SignIn)
    public function authenticate()
    {
        $this->login(); // Reuse the login logic
    }

    // SignIn page view
    public function signIn()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Ensure no redirection to dashboard if session is cleared
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            $this->view('/users/signIn'); // Render the sign-in view
        } else {
            if ($_SERVER['REQUEST_URI'] !== '/dashboard/sell') { // Prevent redirect loop
                $this->redirect("/dashboard/sell");
            }
        }
    }
}
