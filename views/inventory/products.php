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

<style>
    .product-image {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
        margin-left: 10px;
    }
</style>



<div class="products_container">
    <h1 id="h1-products">Products Page</h1>
    <div class="container mt-4">
        <div class="table-container">
            <!-- Custom Search Bar -->
            <div class="table-header">
                <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">

                <!-- Category Filter Dropdown -->
                <select id="categorySelect" name="category">
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>


            </div>
        </div>

        <!-- Table -->
        <table id="productTable" class="table table-striped table-bordered display">
            <thead>
                <tr>
                    <th id="name-pro">Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                <?php foreach ($products as $product): ?>
                    <tr data-category-id="<?= htmlspecialchars($product['category_id']) ?>"> <!-- Corrected data attribute for category ID -->
                        <td>
                            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                <div style="display: flex; align-items: center;">
                                    <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                                        <!-- Correct the src path to be relative to the root -->
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                                    <?php else: ?>
                                        <img src="/path/to/default-image.jpg" alt="Default Image" class="product-image">
                                    <?php endif; ?>
                                </div>
                                <span id="pro-name"><?= htmlspecialchars($product['name']) ?></span>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($product['formatted_price']) ?></td>

                        <td><?= htmlspecialchars($product['stocks']) ?></td>
                        <td>
                            <p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p>
                        </td>
                        <td class="<?= ($product['status'] === 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
                            <?= ucfirst(htmlspecialchars($product['status'])) ?>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="dropbtn btn btn-sm" onclick="toggleDropdown(this)">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                                <div class="dropdown-content" style="display: none;">
                                    <a href="/inventory/edit/<?= $product['id'] ?>">
                                        <span class="material-symbols-outlined">border_color</span> Edit
                                    </a>
                                    <a href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirmDelete(event);">
                                        <span class="material-symbols-outlined">delete</span> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination" id="pagination"></div>
    </div>
    <div class="stocks-container card grid gap-2 p-4">
        <h3>Stock summary:</h3>
        <div class="row mb-3">
            <div class="col-4">
                <div class="stock-summary card">
                    <div class="icon">📦</div>
                    <p>Total Products</p>
                    <h3>0.00</h3>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="icon low-stock">🔻</div>
                    <p>Low-stocks</p>
                    <h3>0.00</h3>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="icon in-stock">📈</div>
                    <p>In-stocks</p>
                    <h3>0.00</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <p>Last Day Update</p>
                    <h3>1/28/2025, 6:50PM</h3>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="icon waste">🗑️</div>
                    <p>Waste</p>
                </div>
            </div>
            <div class="col-4">
                <a href="/inventory/create" class="text-decoration-none">
                    <div class="card">
                        <div class="icon add">➕</div>
                        <p>Add products</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
</div>

</div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        var table = $('#productTable').DataTable({
            "pageLength": 10,
            "paging": true,
            "info": true,
            "lengthChange": false,
            "empty": "No products found",
            "searching": true,
            "dom": '<"top"i>rt<"bottom"lp><"clear">'
        });

        // Search functionality
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#productTable tbody tr");

            rows.forEach(row => {
                let name = row.querySelector("td span").textContent.toLowerCase();
                let category = row.cells[3].textContent.toLowerCase(); // Fixed index for category column

                if (name.includes(input) || category.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        // Category filter functionality
        document.getElementById("categorySelect").addEventListener("change", function() {
            let selectedCategory = this.value;
            let rows = document.querySelectorAll("#productTable tbody tr");

            rows.forEach(row => {
                let categoryId = row.getAttribute('data-category-id');
                if (selectedCategory === "" || categoryId === selectedCategory) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>