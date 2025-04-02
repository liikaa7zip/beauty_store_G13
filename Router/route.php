<?php

use Dom\Notation;

require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/PromotionController.php";
require_once "Controllers/ProductsController.php";
require_once "Controllers/SalesController.php";
require_once "Controllers/CategoryController.php";
require_once "Controllers/EmployeeController.php";
require_once "Controllers/SellController.php";
require_once "Controllers/UserController.php";
require_once "Models/UserModel.php";
require_once "Controllers/NotificationController.php"; 





require_once "Controllers/SellController.php";
require_once "Controllers/UserController.php";
require_once "Models/UserModel.php";
require_once "Models/SalesModel.php";
require_once "Models/NotificationModel.php";
require_once "Models/CategoryModel.php";
require_once "Models/PromotionModel.php";


$route = new Router();
$route->get("/", [UserController::class, 'signIn']); // Redirect root to sign-in page

// Users
$route->get("/users/signUp", [UserController::class, 'login']);
$route->post("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/signIn", [UserController::class, 'signIn']);
$route->post("/users/authenticate", [UserController::class, 'authenticate']);
$route->get("/users/logout", [UserController::class, 'logout']); // Ensure logout route is defined

// Sign In
$route->get('/signin', 'AuthController@showSignInForm');
$route->post('/signin', 'AuthController@signIn');

// Inventory
$route->get("/inventory/products", [ProductsController::class, 'index']);
$route->get("/inventory/edit/{id}", [ProductsController::class, 'edit']);
$route->put("/inventory/update/{id}", [ProductsController::class, 'update']);
$route->post("/inventory/products/store", [ProductsController::class, 'store']);
$route->get("/inventory/delete/{id}", [ProductsController::class, 'delete']);
$route->get("/inventory/create", [ProductsController::class, 'create']);

$route->get("/inventory/product/category/{id}", [ProductsController::class, 'getProductsByCategory']);

// Categories

$route->get("/categories", [CategoryController::class, 'index']);
$route->get("/categories/create", [CategoryController::class, 'create']);
$route->post("/categories/store", [CategoryController::class, 'store']);
$route->get("/categories/edit/{id}", [CategoryController::class, 'edit']);
$route->post("/categories/update/{id}", [CategoryController::class, 'update']);
$route->delete("/categories/delete/{id}", [CategoryController::class, 'delete']);

// Promotion


//Notification
$route->get("/notification", [NotificationController::class, 'index']);
$route->get("/notification/low-stock", [NotificationController::class, 'getLowStockNotifications']);
$route->get("/notification/low-stock-count", [NotificationController::class, 'getLowStockCount']);


//Categories
$route->post("/inventory/store", [CategoryController::class,'store']);

//Promotion
$route->get("/promotion", [PromotionController::class, 'index']);
$route->get("/promotion/create", [PromotionController::class, 'create']);
$route->get("/promotion/edit/{id}", [PromotionController::class, 'edit']);
$route->post("/promotion/store", [PromotionController::class, 'store']);
$route->put("/promotion/update/{id}", [PromotionController::class, 'update']);
$route->delete("/promotion/delete/{id}", [PromotionController::class, 'delete']);

$route->post("/promotion/send/{id}", [PromotionController::class, 'sendPromotion']);



// Employees
$route->get("/employees", [EmployeeController::class, 'index']);
// $route->get('/employees/index', [EmployeeController::class, 'index']);  
$route->get('/employees/create', [EmployeeController::class, 'create']);      // Maps to EmployeeController::add
$route->post('/employees/store', [EmployeeController::class, 'store']);
$route->get('/employees/edit/{id}', [EmployeeController::class, 'edit']);      // Maps to EmployeeController::add
$route->post('/employees/update/{id}', [EmployeeController::class, 'update']);
$route->get('/employees/delete/{id}', [EmployeeController::class, 'destroy']);      // Maps to EmployeeController::add

// Sales
$route->get("/sales", [SalesController::class, 'index']);
$route->post("/sales/create", [SalesController::class, 'store']);


// Dashboard
$route->get("/dashboard/sell", [SellController::class, 'index']);

$route->route();
?>
