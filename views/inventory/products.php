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
                <td><?= htmlspecialchars($product['category_id']) ?></td>
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


