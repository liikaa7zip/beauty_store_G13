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

<div class="products_container">
    <h1 id="h1-products">Products List</h1>
    <div class="container mt-4">
        <div class="table-container">
            <div class="table-header">
                <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">



                <div class="spacer"></div>

                <div class="action-buttons">
                    <button class="import-btn" onclick="triggerImport(); console.log('Import button clicked');">
                        <i class="fa fa-upload"></i> Import
                    </button>
                    <button class="export-btn" onclick="exportToExcel(); console.log('Export button clicked');">
                        <i class="fa fa-download"></i> Export
                    </button>
                </div>
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
                            <div style="display: flex; align-items: center; width: 100%;">
                                <!-- Align the image to the left -->
                                <div style="display: flex; align-items: center;">
                                    <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                                        <img src="/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                                    <?php else: ?>
                                        <img src="/uploads/default-image.jpg" alt="Default Image" class="product-image">
                                    <?php endif; ?>
                                </div>
                                <!-- Center the product name within the available space -->
                                <div style="flex-grow: 1; text-align: center;">
                                    <span id="pro-name"><?= htmlspecialchars($product['name']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($product['price']) ?></td>

                        <td><?= htmlspecialchars($product['stocks']) ?></td>
                        <td>
                            <p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p>
                        </td>
                        <td class="<?= ($product['status'] === 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
                            <?= ucfirst(htmlspecialchars($product['status'])) ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="drop btn btn btn-sm" onclick="toggleDropdown(this)">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                                <div class="dropdown-content" style="display: none;">
                                    <a href="/inventory/edit/<?= $product['id'] ?>">
                                        <span class="material-symbols-outlined" id="edit-pro">border_color</span> Edit
                                    </a>
                                    <a href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirmDelete(event);">
                                        <span class="material-symbols-outlined" id="delete-pro">delete</span> Delete
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
    <script>
        function searchProducts() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#productsTableBody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase(); // Product name
                const price = row.cells[1].textContent.toLowerCase(); // Product price
                const category = row.cells[3].textContent.toLowerCase(); // Product category

                if (name.includes(input) || price.includes(input) || category.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>