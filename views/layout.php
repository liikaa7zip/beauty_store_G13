<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/users/signIn' && $_SERVER['REQUEST_URI'] !== '/users/signUp') {
    header("Location: /users/signUp");
    exit();
}

require_once('layouts/header.php');
if (isset($_SESSION['user_id'])) {
    require_once('layouts/navbar.php');
    require_once('layouts/sidebar.php');
}
?>

<?= $content; ?>

<?php require_once('layouts/footer.php'); ?>