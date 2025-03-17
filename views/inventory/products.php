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
    <div class="table-container">
  <!-- Custom Search Bar -->
  <div class="table-header">
    <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">
    <button id="searchBtn">Search</button>
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
        <td>
    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
        <div style="display: flex; align-items: center;">
            <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                <!-- Correct the src path to be relative to the root -->
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="60" style="margin-right: 10px;">
            <?php else: ?>
                <img src="/path/to/default-image.jpg" alt="Default Image" width="50" style="margin-right: 10px;">
            <?php endif; ?>
        </div>
        <span id="pro-name" ><?= htmlspecialchars($product['name']) ?></span>
    </div>
</td>




          <td><?= htmlspecialchars($product['stocks']) ?></td>
          <td><p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p></td>
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
</div>


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
            <a id="add-products" href="/inventory/create">
                <div class="card">
                    <div class="icon add">➕</div>
                        <p>Add products</p>
                </div>
            </a>
        </div>
    </div>

</div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        "paging": true,  // Enable pagination
        "info": true,    // Show the information (e.g., "Showing 1 to 8 of 25 entries")
        "lengthChange": false, // Disable the option to change the number of items per page
        "dom": '<"top"i>rt<"bottom"lp><"clear">' // Custom layout (pagination at bottom)
    });

    document.getElementById("searchInput").addEventListener("keyup", function() {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#productTable tbody tr");

    rows.forEach(row => {
        let name = row.querySelector("td span").textContent.toLowerCase();
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