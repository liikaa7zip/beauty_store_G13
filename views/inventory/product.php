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
    <!-- write name category in h1 -->
    <h1 id="h1-products">Products List</h1>
    <div class="container mt-4">
        <div class="table-container">
            <div class="table-header">
                <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">
                

                <div class="stock-export-wrapper">
                        <div id="categoryWrapper" style="padding: 5px; border-radius: 10px;">
                            <!-- <select id="categorySelect" name="category" class="custom-dropdown">
                                <option value="">Select category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                </option>
                                    <?php endforeach; ?>
                            </select> -->
                        </div>
                        <div class="stock-export-inner">
                        <div id="stockWrapper">
                            <select id="create-stock" name="stocks" class="custom-dropdown" onchange="filterStocks()">
                                <option value="">Select stock</option>
                                <option value="low">Low Stock</option>
                                <option value="in">In Stock</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div>

        <table id="productTable" class="table table-striped table-bordered display">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                <?php foreach ($products as $product): ?>
                    <tr data-category-id="<?= htmlspecialchars($product['category_id']) ?>">
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div>
                                    <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                                    <?php else: ?>
                                        <img src="/path/to/default-image.jpg" alt="Default Image" class="product-image">
                                    <?php endif; ?>
                                </div>
                                <div style="flex-grow: 1; text-align: center;">
                                    <span><?= htmlspecialchars($product['name']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($product["price"]) ?></td>
                        <td><?= htmlspecialchars($product['stocks']) ?></td>
                        <td><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></td>
                        <td class="<?= ($product['status'] === 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
                            <?= ucfirst(htmlspecialchars($product['status'])) ?>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button">
                                    &#x22EE; <!-- Vertical Ellipsis -->
                                </button>
                                <div class="dropdown-menu">
                                    <a class="text-edit" href="/inventory/edit/<?= $product['id'] ?>">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a class="text-danger" href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirmDelete(event);">
                                        <i class="bi bi-trash"></i> Delete
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
        
</div>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="/views/assets/js/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/read-excel-file/5.4.0/read-excel-file.min.js"></script>

<script src="https://unpkg.com/read-excel-file@5.5.4/bundle/read-excel-file.min.js"></script>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<!-- Custom JavaScript -->
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
    $(document).ready(function() {
        var table = $('#productTable').DataTable({
            "pageLength": 10,
            "paging": true,
            "info": true,
            "lengthChange": false,
            "empty": "No products found",
            "searching": true,
            "dom": '<"top"i>rt<"bottom"lp><"clear">',
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

        // Notification system
        loadNotifications();
        setInterval(loadNotifications, 30000);

        $('#notificationBell').click(function() {
            $('#notificationDropdown').toggle();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.notification-container').length) {
                $('#notificationDropdown').hide();
            }
        });
    });

    function loadNotifications() {
        $.ajax({
            url: '/notification/low-stock',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                updateNotificationUI(data);
            },
            error: function(xhr, status, error) {
                console.error("Error loading notifications:", error);
            }
        });
    }

    function updateNotificationUI(products) {
        const notificationList = $('#notificationList');
        const notificationCount = $('#notificationCount');

        notificationList.empty();

        if (products.length === 0) {
            notificationList.append('<div class="notification-item">No low-stock products</div>');
            notificationCount.text('0');
        } else {
            notificationCount.text(products.length);

            products.forEach(product => {
                const notificationItem = `
                    <div class="notification-item low-stock">
                        <div class="notification-title">Low Stock: ${product.name}</div>
                        <div class="notification-message">Only ${product.stocks} items left</div>
                        <small class="notification-time">Just now</small>
                    </div>
                `;
                notificationList.append(notificationItem);
            });
        }
    }

    function showModal() {
        document.getElementById('category-modal').style.display = 'block';
    }

// Hide the modal
function hideModal() {
    document.getElementById('category-modal').style.display = 'none';
}


    
    
</script>
