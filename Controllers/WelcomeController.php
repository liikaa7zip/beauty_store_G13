<?php
require_once "Models/YourModel.php";
class WelcomeController extends BaseController {
    public function welcome() {
        $this->view('welcome/welcome');
    }
}