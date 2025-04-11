<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
// print_r($sellsProd);
$total = array_reduce($sells, function ($sum, $item) {
    return $sum + $item['total_amount'];
}, 0);

// Ensure $sale is defined and is an array
$sale = $sale ?? []; // Default to an empty array if $sale is not set
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
        <div class="overview-card card p-3" id="total-card" style="width: 20%;">
            <i class="fas fa-box-open overview-icon" id="total"></i>
            <h3 class="overview-title">Total Products</h3>
            <p class="overview-number"><?= count($products) ?></p>
        </div>
        <div class="overview-card card p-3" id="employee-card" style="width: 20%;">
            <i class="fas fa-users overview-icon" id="employee"></i>
            <h3 class="overview-title">Total Employees</h3>
            <p class="overview-number"><?= count($users) ?></p>
        </div>
        <div class="overview-card card p-3" id="sale-card" style="width: 20%;">
            <i class="fas fa-dollar-sign overview-icon" id="sale"></i>
            <h3 class="overview-title">Total Sales</h3>
            <p class="overview-number">$<?= $total ?></p>
        </div>
        <div class="overview-card card p-3" id="orders-card" style="width: 20%;">
            <i class="fas fa-shopping-cart overview-icon" id="orders"></i>
            <h3 class="overview-title">Total Orders</h3>
            <p class="overview-number"><?= count($sale) ?></p>
        </div>
        
    </section>

    <!-- Safely use count() on $sale -->
    <?php if (count($sale) > 0): ?>
        <!-- Render sales data -->
        <?php foreach ($sale as $item): ?>
            <!-- Display $item -->
        <?php endforeach; ?>
    <?php else: ?>
        <p>No sales data available.</p>
    <?php endif; ?>

    <!-- Sales Bar Chart -->
    <section class="sales-chart card p-4">
        <h3>Store Sales (Last 7 Days)</h3>
        <canvas id="salesChart" style="height: 450px; "></canvas>
    </section>

    <!-- Activity Feed Section -->
    <div class="dashboard-container">
        <!-- Activity Feed Section -->
        <section class="activity-feed card p-4">
            <h3>Recent Activity</h3>
            <ul class="activity-list">
                <?php
                require_once 'Models/HistoryModel.php';
                $historyModel = new HistoryModel();
                $activities = $historyModel->getActivityFeed(5);
                
                foreach ($activities as $activity): 
                    $icon = match($activity['type']) {
                        'login' => '👤',
                        'product' => '📦',
                        'category' => '🏷️',
                        'promotion' => '🎁',
                        'sale' => '💰',
                        default => '⚡'
                    };
                ?>
                <li class="activity-item">
                    <div class="activity-icon"><?= $icon ?></div>
                    <div class="activity-details d-flex flex-column align-items-start">
                        <strong><?= htmlspecialchars($activity['description']) ?></strong>
                        <div class="activity-time">
                            <?= date('M j, Y g:i a', strtotime($activity['timestamp'])) ?> by 
                            <?= htmlspecialchars($activity['performed_by']) ?>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>

        

        <!-- Bar Chart Section -->

<section class="chart-container">
    <form method="GET" class="profit_form">
    <label for="month" class="profit_label">Select Month:</label>
    <select name="month" id="month">
        <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?php echo $i; ?>" <?php echo ($i == $selectedMonth) ? 'selected' : ''; ?>>
                <?php echo date("F", mktime(0, 0, 0, $i, 1)); ?>
            </option>
        <?php endfor; ?>
    </select>

    <label for="year" class="profit_label">Select Year:</label>
    <select name="year" id="year" class="profit_select">
        <?php for ($y = 2020; $y <= date('Y'); $y++): ?>
            <option value="<?php echo $y; ?>" <?php echo ($y == $selectedYear) ? 'selected' : ''; ?>>
                <?php echo $y; ?>
            </option>
        <?php endfor; ?>
    </select>

    <button type="submit" class="btn_select">Filter</button>
</form>
    <h3>Profit for <span id="selectedMonth"><?php echo date("F", mktime(0, 0, 0, $selectedMonth, 1)); ?></span>:</h3>
    <p id="totalProfit"><?php echo $sellsProd['total_profit']; ?>$</p>
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
    var profitData = <?php echo json_encode($sellsProd['data']); ?>;
    
    // Update total profit in HTML
    document.getElementById("totalProfit").textContent = "<?php echo $sellsProd['total_profit']; ?>$";

    var productChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($sellsProd['label']); ?>,
            datasets: [{
                label: 'Profit $',
                data: profitData,
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

    // Handle month change without reloading the page (optional)
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault();
        var selectedMonth = document.getElementById("month").value;
        var selectedYear = document.getElementById("year").value;
        window.location.href = "?month=" + selectedMonth + "&year=" + selectedYear;
    });
});



</script>