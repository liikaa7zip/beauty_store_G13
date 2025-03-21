<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id']) && $_SERVER['REQUEST_URI'] !== '/users/signIn') {
    header("Location: /users/signIn");
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
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing code... -->
</head>
<body>
    <!-- ...existing code... -->
    <nav>
        <!-- ...existing code... -->
        <!-- Remove the sign-up link -->
        <!-- <a href="/signUp">Sign Up</a> -->
        <!-- ...existing code... -->
    </nav>
    <!-- ...existing code... -->
</body>
</html>