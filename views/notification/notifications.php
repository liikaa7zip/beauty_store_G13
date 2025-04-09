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
