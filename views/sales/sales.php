<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit(); // Ensure script stops after redirect
} else {
    // Optional: Log the successful session start for debugging
    // error_log("User authenticated with ID: " . $_SESSION['user_id']);
}
?>

<!-- Main Content -->
<div class="main-content1">
    <!-- Sales Section -->
    <div class="sales-section">
        <h2>Sales</h2>
        <p>$700,215</p>
        <select>
            <option>January 2023</option>
            <option>February 2023</option>
            <!-- Add more months as needed -->
        </select>
        <div class="sales-chart">
            <!-- Placeholder for a bar chart -->
            <div class="bar" style="height: 80%;"></div>
            <div class="bar" style="height: 60%;"></div>
            <div class="bar" style="height: 40%;"></div>
            <div class="bar" style="height: 20%;"></div>
        </div>
    </div>

    <!-- Stock Levels Section -->
    <div class="stock-section">
        <h2>Stock levels</h2>
        <canvas id="stockChart"></canvas>
    </div>

    <!-- Popular Products Table -->
    <div class="popular-products1">
        <h2>Popular</h2>
        <button class="add-new-btn1" aria-label="Add a new product" title="Click to add a new product">
            <i class="bi bi-plus-lg"></i> Add New Product
        </button>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Sample product data (to be replaced with database query in production)
                $products = [
                    ["name" => "Sukibushu", "category" => "Toner", "status" => "In stock"],
                    ["name" => "Pone", "category" => "Sunscreen", "status" => "Low stock"],
                    ["name" => "Clivina", "category" => "Lipstick", "status" => "In stock"],
                    ["name" => "Nivea", "category" => "Lotion", "status" => "Low stock"],
                ];

                // Check if products exist
                if (empty($products)) {
                    echo '<tr><td colspan="4">No products available.</td></tr>';
                } else {
                    foreach ($products as $product) {
                        // Sanitize all output to prevent XSS
                        $name = htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8');
                        $category = htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8');
                        $status = htmlspecialchars($product['status'], ENT_QUOTES, 'UTF-8');
                        $statusClass = strtolower($product['status']) === "in stock" ? "in-stock" : "low-stock";

                        // Generate table row
                        echo "<tr>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$category}</td>";
                        echo "<td><span class='status {$statusClass}'>{$status}</span></td>";
                        echo "<td>
                            <button class='action-btn edit-btn' title='Edit'>✏️</button>
                            <button class='action-btn delete-btn' title='Delete'>🗑️</button>
                        </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <!-- <p class="pagination1">123 🡓</p> --> <!-- Uncomment if pagination is implemented -->
    </div>
</div>