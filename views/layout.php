<?php
require_once('layouts/header.php');
if ($_SESSION['user_id']) {
    require_once('layouts/navbar.php');
    require_once('layouts/sidebar.php');
}
?>


<?= $content; ?>

<?php require_once('layouts/footer.php'); ?>