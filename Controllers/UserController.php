<?php 

    class UserController extends BaseController {

        private $users;

        public function login() {
            $this->view('users/signUp');
        }

        public function signIn() {
            $this->view('users/signIn');
        }
       
    }
?>