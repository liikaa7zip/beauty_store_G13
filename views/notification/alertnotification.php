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



<!-- views/////// -->



<?php

class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllNotifications() {
        $query = "SELECT * FROM store_notifications";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNotification($notification_title, $notification_message, $notification_type, $start_date, $end_date, $status) {
        $created_at = date('Y-m-d H:i:s');
        $query = "INSERT INTO store_notifications (notification_title, notification_message, notification_type, start_date, end_date, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->query($query, [$notification_title, $notification_message, $notification_type, $start_date, $end_date, $status, $created_at]);
        return $this->db->lastInsertId();
    }

    public function getNotifications() {
        $query = "SELECT id, notification_title, notification_message, notification_type, start_date, end_date, status, created_at FROM store_notifications";
        $result = $this->db->query($query);

        $notifications = [];
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch()) {
                $notifications[] = $row;
            }
        }
        return $notifications;
    }
     //delete notification missages
    public function deleteNotification($id) {
        try {
            $query = "DELETE FROM store_notifications WHERE id = ?";
            $stmt = $this->db->prepare($query); // Prepare query
            $stmt->execute([$id]); // Execute with parameter
    
            if ($stmt->rowCount() > 0) {
                error_log("Database delete success for ID: " . $id);
                return true;
            } else {
                error_log("Database delete failed for ID: " . $id);
                return false;
            }
        } catch (PDOException $e) {
            error_log("PDO Error deleting notification: " . $e->getMessage());
            return false;
        }
    }
}
?>

<!-- Models/NotificationModel.php -->

<?php

class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new NotificationModel();
    }

    public function index() {
        $notifications = $this->notificationModel->getAllNotifications();
        // include __DIR__ . 'notification/notification';
        include __DIR__ . '/../views/notification/notification .php';
    }
}

// Controller/notification

