<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
?>
<!-- <p>You are logged in!</p>
<a href="/users/logout.php">Logout</a> -->

<main>
        <!-- Welcome Section -->
        <section class="welcome">
            <h2>Welcome, John Doe!</h2>
            <p>Here's a quick overview of your store's performance and activity.</p>
        </section>


        <section class="store-overview">
    <div class="overview-card">
        <i class="fas fa-box-open overview-icon" id="total"></i>
        <h3 class="overview-title">Total Products</h3>
        <p class="overview-number">150</p>
    </div>
    <div class="overview-card">
        <i class="fas fa-users overview-icon" id="employee"></i>
        <h3 class="overview-title">Total Employees</h3>
        <p class="overview-number">25</p>
    </div>
    <div class="overview-card">
        <i class="fas fa-dollar-sign overview-icon" id="sale"></i>
        <h3 class="overview-title">Total Sales</h3>
        <p class="overview-number">$12,000</p>
    </div>
    <div class="overview-card">
        <i class="fas fa-shopping-cart overview-icon" id="orders"></i>
        <h3 class="overview-title">Total Orders</h3>
        <p class="overview-number">450</p>
    </div>
    <div class="overview-card">
        <i class="fas fa-user-check overview-icon" id="users"></i>
        <h3 class="overview-title">Active Users</h3>
        <p class="overview-number">98</p>
    </div>
</section>



        <!-- Sales Bar Chart -->
        <section class="sales-chart">
            <h3>Store Sales (Last 7 Days)</h3>
            <canvas id="salesChart"></canvas>
        </section>

        <!-- Activity Feed Section -->
        <section class="activity-feed">
            <h3>Recent Activity</h3>
            <ul>
                <li>User "Jane" added a new product</li>
                <li>Order #1254 completed successfully</li>
                <li>User "Tom" updated profile information</li>
                <li>New stock of product "Laptop XYZ" received</li>
                <li>Order #1200 shipped to customer</li>
            </ul>
        </section>

        <!-- Motivational Section -->
        <section class="motivational">
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
                        data: [500, 700, 800, 600, 900, 1200, 1100], // Sample data
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
                                    return '$' + tooltipItem.raw;  // Add dollar sign to sales value
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
    </script>