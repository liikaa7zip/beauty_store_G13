<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        .notification-item {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 5px solid #ff4757;
        }
    </style>
</head>
<body>
    <h1>Notifications</h1>
    <div class="notification-list">
        <?php if (empty($notifications)): ?>
            <p>No notifications available.</p>
        <?php else: ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item">
                    <h4><?= htmlspecialchars($notification['notification_title']) ?></h4>
                    <p><?= htmlspecialchars($notification['notification_message']) ?></p>
                    <small>Valid until: <?= htmlspecialchars($notification['end_date']) ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>