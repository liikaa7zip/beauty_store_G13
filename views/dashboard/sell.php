<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
$total = array_reduce($sells, function ($sum, $item) {
    return $sum + $item['total_amount'];
}, 0);
?>
<!-- <p>You are logged in!</p>
<a href="/users/logout.php">Logout</a> -->

<main class="d-flex flex-column gap-3">
    <!-- Welcome Section -->
    <section class="welcome">
        <h2>Welcome, <?= $_SESSION['user_name'] ? $_SESSION['user_name'] : 'Unknown' ?></h2>
        <p>Here's a quick overview of your store's performance and activity.</p>
    </section>

    <section class="store-overview d-flex justify-content-evenly">
        <div class="overview-card card p-3" id="total-card">
            <i class="fas fa-box-open overview-icon" id="total"></i>
            <h3 class="overview-title">Total Products</h3>
            <p class="overview-number"><?= count($products) ?></p>
        </div>
        <div class="overview-card card p-3" id="employee-card">
            <i class="fas fa-users overview-icon" id="employee"></i>
            <h3 class="overview-title">Total Employees</h3>
            <p class="overview-number"><?= count($users) ?></p>
        </div>
        <div class="overview-card card p-3" id="sale-card">
            <i class="fas fa-dollar-sign overview-icon" id="sale"></i>
            <h3 class="overview-title">Total Sales</h3>
            <p class="overview-number">$<?= $total ?></p>
        </div>
        <div class="overview-card card p-3" id="orders-card">
            <i class="fas fa-shopping-cart overview-icon" id="orders"></i>
            <h3 class="overview-title">Total Orders</h3>
            <p class="overview-number">450</p>
        </div>
        <div class="overview-card card p-3" id="users-card">
            <i class="fas fa-user-check overview-icon" id="users"></i>
            <h3 class="overview-title">Active Users</h3>
            <p class="overview-number">98</p>
        </div>
    </section>



    <!-- Sales Bar Chart -->
    <section class="sales-chart card p-4">
        <h3>Store Sales (Last 7 Days)</h3>
        <canvas id="salesChart"></canvas>
    </section>

    <!-- Activity Feed Section -->
    <div class="dashboard-container">
        <!-- Activity Feed Section -->
        <section class="activity-feed">
            <h3>Recent Activity</h3>
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon icon-product">🛒</div>
                    <div class="activity-details">
                        <strong>User "Jane"</strong> added a new product
                        <div class="activity-time">10 mins ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon icon-order">✅</div>
                    <div class="activity-details">
                        <strong>Order #1254</strong> completed successfully
                        <div class="activity-time">30 mins ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon icon-user">👤</div>
                    <div class="activity-details">
                        <strong>User "Tom"</strong> updated profile information
                        <div class="activity-time">1 hour ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon icon-stock">📦</div>
                    <div class="activity-details">
                        <strong>New stock</strong> of product "Laptop XYZ" received
                        <div class="activity-time">3 hours ago</div>
                    </div>
                </li>
                <li class="activity-item">
                    <div class="activity-icon icon-order">🚚</div>
                    <div class="activity-details">
                        <strong>Order #1200</strong> shipped to customer
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </li>
            </ul>
        </section>

        <!-- Bar Chart Section -->
        <section class="chart-container">
            <h3>Product Sales</h3>
            <canvas id="productChart"></canvas>
        </section>
    </div>

    <!-- Motivational Section -->
    <section class="motivational p-4">
        <h3>Keep up the great work!</h3>
        <p>Your store is growing, keep pushing for even better performance!</p>
    </section>
</main>


<!-- Chart.js Script -->
<script>
    // Ensure the chart renders after the DOM has loaded
    window.onload = function() {
        // Get the context of the canvas element for Chart.js
        const ctx = document.getElementById('salesChart').getContext('2d');

        // Create a new chart instance
        const salesChart = new Chart(ctx, {
            type: 'bar', // Type of chart
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Sales in USD',
                    data: <?php echo (json_encode($lastSales)) ?>, // Sample data
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Bar color
                    borderColor: 'rgba(255, 99, 132, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, // Ensures the chart resizes with the window
                plugins: {
                    legend: {
                        position: 'top', // Position of legend
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return '$' + tooltipItem.raw; // Add dollar sign to sales value
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true // Start the y-axis at 0
                    }
                }
            }
        });
    };

    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D'],
                datasets: [{
                    label: 'Sales',
                    data: [150, 200, 180, 120],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>