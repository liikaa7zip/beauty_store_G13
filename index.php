<?php
session_start();

// Define allowed routes for unauthenticated users
$allowedRoutes = ['/users/signIn', '/users/authenticate'];

// Check if the user is authenticated
if (!isset($_SESSION['user_id']) && !in_array($_SERVER['REQUEST_URI'], $allowedRoutes)) {
    // Redirect to the sign-in page if the user is not authenticated
    header("Location: /users/signIn");
    exit;
}

require 'Router/route.php';
?>

