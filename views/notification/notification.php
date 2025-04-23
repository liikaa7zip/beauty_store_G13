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

        // Call the deleteNotification method to remove the notification from the database
        $isDeleted = $notificationModel->deleteNotification($id);

        if ($isDeleted) {
            echo json_encode(['status' => 'success', 'message' => 'Notification deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete notification.']);
        }
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
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            const notificationId = this.getAttribute("data-id");
            const modal = document.getElementById("deleteModal");

            // Show the modal
            modal.style.display = "block";

            // Handle confirm delete
            const confirmButton = modal.querySelector(".confirm-delete");
            confirmButton.onclick = function () {
                fetch(`/notification/delete/${notificationId}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Remove the notification from the UI
                        const notificationElement = button.closest(".notification");
                        if (notificationElement) {
                            notificationElement.remove();
                        }
                        modal.style.display = "none"; // Close the modal
                    } else {
                        alert("Failed to delete notification.");
                    }
                })
                .catch(error => console.error("Error deleting notification:", error));
            };

            // Handle cancel delete
            const cancelButton = modal.querySelector(".cancel-delete");
            cancelButton.onclick = function () {
                modal.style.display = "none"; // Close the modal
            };
        });
    });
});
</script>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this notification?</p>
        <div class="modal-actions">
            <button class="cancel-delete">Cancel</button>
            <button class="confirm-delete">Delete</button>
        </div>
    </div>
</div>

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
                        <a class="delete-btn" href="#" data-id="<?= $notification['id'] ?>">×</a>
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
