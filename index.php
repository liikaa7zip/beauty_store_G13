<?php
session_start();

// Redirect to sign-in page if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /signIn");
    exit;
}

require 'Router/route.php';
?>

