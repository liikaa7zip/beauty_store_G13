<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signUp");
    exit();
}
?>

<div class="header-container">
    <h1 class="h1stock">Stock Products</h1>
    <div class="header-controls">
        <div class="search-container">
            <input type="text" id="searchProducts" placeholder="Search products...">
            <span class="material-symbols-outlined search-icon">search</span>
        </div>
        <div class="category-filter">
            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="tshirt">T-shirt</option>
                <option value="bags">Bags</option>
                <option value="hat">Hat</option>
                <option value="pants">Pants</option>
                <option value="dress">Dress</option>
                <option value="shoes">Shoes</option>
            </select>
        </div>
        <div class="excel-controls">
            <button class="excel-btn import-btn" onclick="importExcel()">
                <span class="material-symbols-outlined">upload</span> Import
            </button>
            <button class="excel-btn export-btn" onclick="exportExcel()">
                <span class="material-symbols-outlined">download</span> Export
            </button>
        </div>
    </div>
</div>

<section id="stocks">
    <table>
        <thead>
            <tr>
                <th class="name-cell">Product Name</th>
                <th>Stocks</th>
                <th class="stock-cell">Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['stocks']) ?></td>
                    <td><?= htmlspecialchars($product['category_id']) ?></td>
                    <td class="<?= ($product['status'] == 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
                        <?= ucfirst(htmlspecialchars($product['status'])) ?>
                    </td>
                    <td>
                        <a href="/inventory/edit/<?= $product['id'] ?>" class="edit-btn">
                            <span class="material-symbols-outlined">border_color</span>
                        </a>
                        <a href="/inventory/delete/<?= $product['id'] ?>" class="delete-btn">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<div class="container">
    <h3>Stock Summary:</h3>
    <div class="stock-summary">
        <div class="card"><div class="icon">📦</div><p>Total Products</p><h3>100</h3></div>
        <div class="card"><div class="icon low-stock">🔻</div><p>Low Stock</p><h3>250</h3></div>
        <div class="card"><div class="icon in-stock">📈</div><p>In Stock</p><h3>103</h3></div>
        <div class="card"><p>Last Update</p><h3>1/28/2025, 6:50 PM</h3></div>
        <div class="card"><div class="icon waste">🗑️</div><p>Waste</p></div>
        <div class="card add-product-btn" id="addProductBtn" style="cursor: pointer;"><div class="icon">➕</div><p>Add Product</p></div>
    </div>
</div>


<div id="addProductModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add New Product</h2>
        <form id="addProductForm">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" required>
            
            <label for="category">Category:</label>
            <select id="category" name="category">
                <option value="tshirt">T-shirt</option>
                <option value="bags">Bags</option>
                <option value="hat">Hat</option>
                <option value="pants">Pants</option>
                <option value="dress">Dress</option>
                <option value="shoes">Shoes</option>
            </select>
            
            <label for="stocks">Stocks:</label>
            <input type="number" id="stocks" name="stocks" required>
            
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="instock">In Stock</option>
                <option value="low-stock">Low Stock</option>
            </select>
            
            <button type="submit" class="btn-submit">Add Product</button>
        </form>
    </div>
</div>




<!-- <script src="../views/assets/js/add.js"></script> -->