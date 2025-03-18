<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/PromotionController.php";
require_once "Controllers/ProductsController.php";




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



//Inventory

$route->get("/inventory/products", [ProductsController::class, 'index']);
$route->get("/inventory/edit/{id}", [ProductsController::class, 'edit']);
$route->put("/inventory/products/update/{id}", [ProductsController::class, 'update']);
$route->post("/inventory/products/store", [ProductsController::class, 'store']);
$route->get("/inventory/delete/{id}", [ProductsController::class, 'delete']);
$route->get("/inventory/create", [ProductsController::class, 'create']);




//Promotion
$route->get("/promotion", [PromotionController::class, 'index']);
$route->get("/promotion/create", [PromotionController::class, 'create']);
$route->get("/promotion/edit/{id}", [PromotionController::class, 'edit']);
$route->post("/promotion/store", [PromotionController::class, 'store']);
$route->put("/promotion/update/{id}", [PromotionController::class, 'update']);
$route->delete("/promotion/delete/{id}", [PromotionController::class, 'delete']);

// Dashboard
$route->get("/dashboard/sell", [SellController::class, 'index']);


$route->route();