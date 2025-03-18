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

<!-- Main Content -->
<div class="main-content1">
            <!-- Sales Section -->
            <div class="sales-section">
                <h2>Sales</h2>
                <p>$700,215</p>
                <select>
                    <option>January 2023</option>
                    <option>February 2023</option>
                    <!-- Add more months -->
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
            <div class="popular-products">
                <h2>Popular</h2>
                <button class="add-new-btn">+ Add new</button>
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
                        // Sample data (you can replace this with a database query)
                        $products = [
                            ["name" => "Sukibushu", "category" => "Toner", "status" => "In stock"],
                            ["name" => "Pone", "category" => "Sunscreen", "status" => "Low stock"],
                            ["name" => "Clivina", "category" => "Lipstick", "status" => "In stock"],
                            ["name" => "Nivea", "category" => "Lotion", "status" => "Low stock"],
                        ];

                        foreach ($products as $product) {
                            $statusClass = strtolower($product['status']) === "in stock" ? "in-stock" : "low-stock";
                            echo "<tr>";
                            echo "<td>" . $product['name'] . "</td>";
                            echo "<td>" . $product['category'] . "</td>";
                            echo "<td><span class='status $statusClass'>" . $product['status'] . "</span></td>";
                            echo "<td>
                                <button class='action-btn edit-btn'>✏️</button>
                                <button class='action-btn delete-btn'>🗑️</button>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- <p class="pagination1">123 🡓</p> -->
            </div>
        </div>
    </div>
