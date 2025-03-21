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
        
        <div id="categoryWrapper">
            <select id="categorySelect" name="category">
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

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
                                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                            <?php else: ?>
                                <img src="/path/to/default-image.jpg" alt="Default Image" class="product-image">
                            <?php endif; ?>
                        </div>
                        <!-- Center the product name within the available space -->
                        <div style="flex-grow: 1; text-align: center;">
                            <span id="pro-name"><?= htmlspecialchars($product['name']) ?></span>
                        </div>
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
        <div class="stocks-container card grid gap-2 p-4">
            <h3>Stock summary:</h3>
            <div class="row mb-3">
        <div class="col-4">
            <div class="stock-summary card" id="total-products">
                <div class="icon">📦</div>
                <p>Total Products</p>
                <h3>0.00</h3> <!-- This will be updated -->
            </div>
        </div>
        <div class="col-4">
            <div class="card" id="low-stocks">
                <div class="icon low-stock">🔻</div>
                <p>Low-stocks</p>
                <h3>0.00</h3> <!-- This will be updated -->
            </div>
        </div>
        <div class="col-4">
            <div class="card" id="in-stocks">
                <div class="icon in-stock">📈</div>
                <p>In-stocks</p>
                <h3>0.00</h3> <!-- This will be updated -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <a href="javascript:void(0);" class="text-decoration-none" onclick="showModal()"><div class="card" id="add-product">
            <div class="icon add">➕</div>
            <p>Add New Categories</p>
        </div>
    </a>

<!-- Modal for adding a category -->
<div id="category-modal" class="category-modal" style="display:none;">
    <div class="modal-content">
        <h3>Create New Category</h3>
        <form action="/inventory/store" method="POST">
    <label for="category-name" id="cat-name">Category Name:</label>
    <input type="text" id="category-name" name="category_name" required autocomplete="off">

    <label for="category-description" id="cat-desc">Category Description:</label>
    <textarea id="category-description" name="category_description" required></textarea>

    <input type="hidden" name="csrf_token" value="">

    <div class="modal-buttons">
        <button type="submit" class="cat-btn">Create Category</button>
        <button type="button" onclick="hideModal()" class="btn-secondary">Cancel</button>
    </div>
</form>

    </div>
</div>


                </div>
                <div class="col-4">
                    <div class="card" id="waste">
                        <div class="icon waste">🗑️</div>
                        <p>Waste</p>
                    </div>
                </div>
                <div class="col-4">
                    <a href="/inventory/create" class="text-decoration-none">
                        <div class="card" id="add-product">
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

// Show the modal
function showModal() {
    document.getElementById('category-modal').style.display = 'block';
}

// Hide the modal
function hideModal() {
    document.getElementById('category-modal').style.display = 'none';
}


    
    
</script>

