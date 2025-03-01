<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/StockController.php";
require_once "Controllers/SellController.php";




$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);


//Inventory
$route->get("/inventory/stock", [StockController::class, 'stock_inventory']);
$route->get("/inventory/stock", [StockController::class, 'index']);

//dashboard
$route->get("/dashboard/sell", [SellController::class, 'index']);

$route->route();