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


        <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let notificationId = this.getAttribute("data-id");
                    console.log("Attempting to delete ID:", notificationId); // Log ID

                    if (confirm("Are you sure you want to delete this notification?")) {
                        fetch(window.location.href, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                            },
                            body: "delete_id=" + encodeURIComponent(notificationId)
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Server response:", data); // Log response

                            if (data.status === "success") {
                                this.parentElement.remove(); // Remove from UI
                            } else {
                                alert("Failed to delete notification: " + data.message);
                            }
                        })
                        .catch(error => console.error("Fetch error:", error));
                    }
                });
            });
        });
</script>




<main class="app-main">
    <div class="container">
        <section class="notifications">
            <h2>Alert Notifications</h2>
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