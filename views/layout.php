<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;

require_once('layouts/header.php');
if ($user_id) {
    require_once('layouts/navbar.php');
    require_once('layouts/sidebar.php');
}
?>

<?= $content; ?>

<?php require_once('layouts/footer.php'); ?>