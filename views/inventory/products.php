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
        <div class="table-container card">
            <!-- Custom Search Bar -->
            <div class="table-header grid">
                <div class="row">
                    <div class="col d-flex">
                        <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">
                        <button id="searchBtn">Search</button>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <table id="productTable" class="table table-striped table-bordered display">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['stocks']) ?></td>
                            <td>
                                <p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p>
                            </td>
                            <td class="<?= ($product['status'] === 'low-stock') ? 'text-danger' : 'text-success' ?>">
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
            "pageLength": 10, // Show 8 products per page
            "paging": true, // Enable pagination
            "info": true, // Show the information (e.g., "Showing 1 to 8 of 25 entries")
            "lengthChange": false, // Disable the option to change the number of items per page
            "empty": "No products found",
            "searching": true, // Enable searching
            "dom": '<"top"i>rt<"bottom"lp><"clear">' // Custom layout (pagination at bottom)
        });

        document.getElementById("searchInput").addEventListener("keyup", function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll("#productTable tbody tr");

            rows.forEach(row => {
                let name = row.cells[0].textContent.toLowerCase();
                let category = row.cells[2].textContent.toLowerCase();

                if (name.includes(input) || category.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>