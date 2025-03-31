<!-- filepath: c:\Users\Retthy.Dork\Desktop\beauty_store_G13\views\notification\createLowStockNotification.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Notifications</title>
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Adjust the path as needed -->
</head>
<body>
    <div class="container">
        <h1>Low Stock Notifications</h1>
        <?php if (!empty($notifications)): ?>
            <ul class="notification-list">
                <?php foreach ($notifications as $notification): ?>
                    <li class="notification-item">
                        <h3><?= htmlspecialchars($notification['notification_title']) ?></h3>
                        <p><?= htmlspecialchars($notification['notification_message']) ?></p>
                        <small>
                            Start Date: <?= htmlspecialchars($notification['start_date']) ?><br>
                            End Date: <?= htmlspecialchars($notification['end_date']) ?>
                        </small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No low-stock notifications at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>