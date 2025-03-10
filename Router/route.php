<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/StockController.php";
require_once "Controllers/PromotionController.php";




$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);


//Inventory
$route->get("/inventory/stock", [StockController::class, 'stock_inventory']);
$route->get("/inventory/stock", [StockController::class, 'index']);

//Promotion
$route->get("/promotion/promotion", [PromotionController::class, 'promotion']);
$route->get("/promotion/promotion", [PromotionController::class, 'index']);
$route->get("/promotion/create", [PromotionController::class, 'create']);
$route->post("/promotion/store", [PromotionController::class, 'store']);
$route->put("/promotion/update", [PromotionController::class, 'update']);
$route->delete("/promotion/delete", [PromotionController::class, 'destroy']);

$route->route();