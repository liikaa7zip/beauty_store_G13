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
    <h1 id="h1-products">Products Page</h1>

    <div class="container mt-4">
        
    <table id="productTable" class="display">
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
        <td><p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p></td> <!-- Display category name -->
        <td class="<?= ($product['status'] === 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
            <?= ucfirst(htmlspecialchars($product['status'])) ?>
        </td>
        <td>
            <div class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown(this)">
                    <span class="material-symbols-outlined">more_horiz</span>
                </button>
                <div class="dropdown-content">
                    <a href="/inventory/edit/<?= $product['id'] ?>">
                        <span class="material-symbols-outlined" id="edit">border_color</span> Edit
                    </a>
                    <a href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                        <span class="material-symbols-outlined" id="delete">delete</span> Delete
                    </a>
                </div>
            </div>
        </td>
    </tr>
<?php endforeach; ?>

    </tbody>
</table>

<div class="pagination" id="pagination"></div>
        <div class="stocks-container">
        <h3>Stock summary:</h3>
        <div class="stock-summary">
            <div class="card">
                <div class="icon">📦</div>
                <p>Total Products</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <div class="icon low-stock">🔻</div>
                <p>Low-stocks</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <div class="icon in-stock">📈</div>
                <p>In-stocks</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <p>Last Day Update</p>
                <h3>1/28/2025, 6:50PM</h3>
            </div>
            <div class="card">
                <div class="icon waste">🗑️</div>
                <p>Waste</p>
            </div>
            <div class="card">
                <div class="icon add">➕</div>
                <p>Add products</p>
            </div>
        </div>
    </div>

</div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
$(document).ready(function() {
    $('#productTable').DataTable({
        "pageLength": 7, // Show 7 products per page
        "lengthChange": false, // Hide "Show X entries"
        "searching": true, // Enable search bar
        "ordering": true, // Enable sorting
        "paging": true // Enable pagination  
        
    });
});
</script>


<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Product</h2>
        <form id="addProductForm">
            <!-- Product Name and Price in the same line -->
            <div class="row">
                <div class="form-group">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" name="productName" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
            </div>

            <!-- Other fields -->
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="tshirt">T-shirt</option>
                <option value="bags">Bags</option>
                <option value="hat">Hat</option>
                <option value="pants">Pants</option>
                <option value="dress">Dress</option>
                <option value="shoes">Shoes</option>
            </select>

            <label for="stocks">Stocks:</label>
            <input type="number" id="stocks" name="stocks" required>

            <label for="inscription">Inscription:</label>
            <input type="text" id="inscription" name="inscription">

            <!-- Product Image field -->
            <label for="productImage">Product Image:</label>
            <input type="file" id="productImage" name="productImage" accept="image/*">

            <button type="submit" class="btn-submit">Add Product</button>
        </form>
    </div>
</div>