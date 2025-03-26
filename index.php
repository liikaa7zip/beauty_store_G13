<?php
session_start();

// Redirect to sign-in page if the user is not authenticated
if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/users/signIn' && $_SERVER['REQUEST_URI'] !== '/users/authenticate') {
    header("Location: /users/signIn");
    exit;
}

require 'Router/route.php';
?>

