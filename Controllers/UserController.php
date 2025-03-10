<?php 

    require_once "Models/UserModel.php";
    class UserController extends BaseController {

        private $users;

        public function __construct() {
            $this->users = new UserModel();
        }

        public function login() {
            $this->view('users/signUp');
        }

        public function store()
        {
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
                echo "All fields are required.";
                return;
            }

            $username = htmlentities($_POST['username']);
            $email = htmlentities($_POST['email']);
            $password = htmlentities($_POST['password']);
            $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
            $role = htmlentities($_POST['role']);
            
            if ($this->users->getUserByUsername($username)) {
                echo "Username already exists.";
                return;
            }
            if ($this->users->getUserByEmail($email)) {
                echo "Email already exists.";
                return;
            }
            
            $this->users->createUser($username, $email, $encrypted_password, $role);
            $this->redirect("/dashboard/sell");
        }

        public function authenticate() {
            session_start();
            if (empty($_POST['email']) || empty($_POST['password'])) {
                echo "Email and password are required.";
                return;
            }

            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->users->getUserByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_name'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $this->redirect("/dashboard/sell");
            } else {
                echo "Invalid email or password.";
            }
        }

        public function signIn() {
            if (isset($_SESSION['user_id'])) {
                $this->redirect("/dashboard/sell");
            } else {
                $this->view('users/signIn');
            }
        }
        public function create()
    {
        $this->view('inventory/create');
    }
    }
?>