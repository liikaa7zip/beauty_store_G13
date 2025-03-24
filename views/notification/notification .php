<?php
ob_start(); // Start output buffering

// Require the NotificationModel class
require_once __DIR__ . '/../../Models/NotificationModel.php';

// Create a new instance of the NotificationModel class
$notificationModel = new NotificationModel();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $notificationModel->deleteNotification($id);
        echo json_encode(['status' => 'success']);
        exit;
    } else {
        $notification_title = $_POST['notification_title'];
        $notification_message = $_POST['notification_message'];
        $notification_type = $_POST['notification_type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $status = $_POST['status'];

        $id = $notificationModel->addNotification($notification_title, $notification_message, $notification_type, $start_date, $end_date, $status);

        // Return the inserted data as JSON
        echo json_encode([
            'id' => $id,
            'notification_title' => $notification_title,
            'notification_message' => $notification_message,
            'notification_type' => $notification_type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
}

// Fetch notifications from the database
$notifications = $notificationModel->getNotifications();
?>

</head>
<body>
<main class="app-main">
    <div class="container">
        <!-- <section class="form-container">
            <h2>Add Notification</h2>
            <form id="notificationForm">
                <label for="notification_title">Notification Title:</label>
                <input type="text" id="notification_title" name="notification_title" required><br><br>
                <label for="notification_message">Notification Message:</label>
                <input type="text" id="notification_message" name="notification_message" required><br><br>
                <label for="notification_type">Notification Type:</label>
                <input type="text" id="notification_type" name="notification_type" required><br><br>
                <label for="start_date">Start Date:</label>
                <input type="datetime-local" id="start_date" name="start_date" required><br><br>
                <label for="end_date">End Date:</label>
                <input type="datetime-local" id="end_date" name="end_date" required><br><br>
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required><br><br>
                <button type="submit">Add Notification</button>
            </form>
        </section> -->
        <section class="notifications">
            <h2>Notifications</h2>
            <div id="notificationsContainer">
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification">
                        <div class="content">
                            <strong><?php echo htmlspecialchars($notification['notification_title']); ?></strong><br>
                            <?php echo htmlspecialchars($notification['notification_message']); ?><br>
                            <?php echo htmlspecialchars($notification['created_at']); ?>
                        </div>
                        <button class="delete-btn" data-id="<?php echo $notification['id']; ?>">×</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php
$content = ob_get_clean(); // Get the buffered content and clean the buffer
$layoutPath = __DIR__ . '/../layout.php';
if (file_exists($layoutPath)) {
    include $layoutPath;
} else {
    echo "Error: layout.php not found at $layoutPath";
}
?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>