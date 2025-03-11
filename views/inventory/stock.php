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

<link rel="stylesheet" href="/css/create.css">
<div class="header-container"> 
    <div class="h1stock">Stock Products</div>
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
                <!-- <button class="excel-btn add-btn" id="addNewBtn">
                  <span class="material-symbols-outlined">add</span>
                  Add New
                </button> -->
                <!-- <button onclick="createFunction()">Create</button> -->
                <!-- <form method="post">
                  <button type="submit" name="create">Create</button>
                </form> -->

                <!-- <button class="excel-btn import-btn" onclick="importExcel()">
                  <span class="material-symbols-outlined">upload</span>
                  Import
                </button>
                <button class="excel-btn export-btn" onclick="exportExcel()">
                  <span class="material-symbols-outlined">download</span>
                  Export
                </button>
                <button class="excel-btn import-btn" onclick="ADD()"> -->
              </div>
            </div>
          </div>
         
          <section id="stocks">
            <table id="productTable" class="display">
              <thead>
                <tr>
                  <th class="name-cell">ProductName</th>
                  <th>Stocks</th>
                  <th class="stock-cell">Category</th>
                  <th >Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- Rows with stock data will go here -->
                <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $product['stocks']?></td>
                <td><?= $product['category_id'] ?></td>
                <td class="<?= ($product['status'] == 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
                  <?= ucfirst($product['status']) ?>
                </td>
                <td>
                    <a href="/inventory/edit/<?= $product['id'] ?>">
                      <span class="material-symbols-outlined" id="edit">border_color</span>
                    </a>
                    <a href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">
                      <span class="material-symbols-outlined" id="delete">delete</span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
              </tbody>
            </table>
          </section>
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
        "searching": false, // Enable search bar
        "ordering": true, // Enable sorting
        "paging": true // Enable pagination  
        
    });
});
</script>










