<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/StockController.php";
require_once "Controllers/PromotionController.php";



require_once "Controllers/SellController.php";
require_once "Controllers/UserController.php";
require_once "Models/UserModel.php";

$route = new Router();
$route->get("/", [UserController::class, 'login']);

// Users
$route->get("/users/signUp", [UserController::class, 'login']);
$route->post("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/signIn", [UserController::class, 'signIn']);
$route->post("/users/authenticate", [UserController::class, 'authenticate']);

// Inventory
$route->get("/inventory/stock", [StockController::class, 'index']);
$route->get("/inventory/delete/{id}", [StockController::class, 'delete']);



//Promotion
$route->get("/promotion", [PromotionController::class, 'index']);
$route->get("/promotion/create", [PromotionController::class, 'create']);
$route->post("/promotion/store", [PromotionController::class, 'store']);
$route->post("/promotion/update", [PromotionController::class, 'update']);
$route->delete("/promotion/delete", [PromotionController::class, 'delete']);

// Dashboard
$route->get("/dashboard/sell", [SellController::class, 'index']);

$route->route();