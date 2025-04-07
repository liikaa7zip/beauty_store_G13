<?php if (isset($_SESSION['success'])): ?>
    
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="customers-list">
    <h1>Customers</h1>

    <!-- Create Customer Form -->
    <h2>Add New Customer</h2>
    <form method="post" action="/customers/create">
        <div class="input-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="input-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        <div class="input-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="input-group">
            <label for="total_debt">Total Debt:</label>
            <input type="number" id="total_debt" name="total_debt" step="0.01" min="0" value="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Customer</button>
    </form>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Total Debt</th>
                <th>Unpaid Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                <td>
                    <?php 
                    $totalUnpaid = 0;
                    if (!empty($unpaidProducts[$customer['id']])): ?>
                        <ul class="unpaid-list">
                            <?php foreach ($unpaidProducts[$customer['id']] as $product): 
                                $totalUnpaid += $product['price']; ?>
                                <li>
                                    <?= htmlspecialchars($product['name']) ?> - 
                                    <?= $product['quantity'] ?> x $<?= number_format($product['price'], 2) ?>
                                    <br>
                                    <small>Date: <?= $product['sale_date'] ?></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="total-unpaid">
                            Total Unpaid: $<?= number_format($totalUnpaid, 2) ?>
                        </div>
                    <?php else: ?>
                        <p><?= number_format($customer['total_debt'], 2) ?></p>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($unpaidProducts[$customer['id']])): ?>
                        <ul>
                            <?php foreach ($unpaidProducts[$customer['id']] as $product): ?>
                                <li><?php echo htmlspecialchars($product['name']); ?> - 
                                    <?php echo $product['quantity']; ?> x $<?php echo number_format($product['price'], 2); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No unpaid products.</p>
                    <?php endif; ?>
                </td>
                <td>
                <div class="dropdown">
    <button class="dropdown-toggle" type="button">
        &#x22EE; <!-- Vertical Ellipsis -->
    </button>
    <div class="dropdown-menu">
        <a href="/customers/view/<?= $customer['id'] ?>">
            <i class="bi bi-eye"></i> View
        </a>
        <a href="/customers/edit/<?= $customer['id'] ?>">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="#" class="text-danger" onclick="showModal(<?= $customer['id'] ?>)">
            <i class="bi bi-trash"></i> Delete
        </a>
    </div>
</div>

<!-- Update the modal structure -->
<div id="deleteModal<?= $customer['id'] ?>" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Confirm Deletion</h5>
            <span class="close-modal" onclick="closeModal(<?= $customer['id'] ?>)">&times;</span>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <?= htmlspecialchars($customer['name']) ?>?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-cancel" onclick="closeModal(<?= $customer['id'] ?>)">Cancel</button>
            <a href="/customers/delete/<?= $customer['id'] ?>" class="btn btn-delete">Delete</a>
        </div>
    </div>
</div>

        </ul>
    </div>
</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
// Add this at the beginning of your script section
document.addEventListener('DOMContentLoaded', function() {
    // Handle dropdown toggle clicks
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;
            
            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdown) {
                    menu.style.display = 'none';
                }
            });
            
            // Toggle current dropdown
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
});

// Your existing modal functions
function showModal(id) {
    const modal = document.getElementById('deleteModal' + id);
    if (modal) {
        modal.style.display = 'block';
    }
}

function closeModal(id) {
    const modal = document.getElementById('deleteModal' + id);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
    }
}

// Prevent modal from closing when clicking inside modal-content
document.querySelectorAll('.modal-content').forEach(content => {
    content.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>

<!-- Update the dropdown CSS -->
<style>
/* Add these styles to your existing CSS */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 5px 10px;
    color: #333;
}

.dropdown-toggle:hover {
    color: #007bff;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 150px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    z-index: 1000;
    margin-top: 5px;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.2s;
}

.dropdown-menu a:hover {
    background-color: #f8f9fa;
}

.dropdown-menu a.text-danger {
    color: #dc3545;
}

.dropdown-menu a.text-danger:hover {
    background-color: #fff5f5;
}

.dropdown-menu i {
    margin-right: 8px;
    font-size: 16px;
}



.customers-list {
    padding: 20px;
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #f5f5f5;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 12px;
}

.btn-primary {
    background-color: #007bff;
    border: 1px solid #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.table th:nth-child(2),
.table td:nth-child(2),
.table th:nth-child(3),
.table td:nth-child(3),
.table th:nth-child(4),
.table td:nth-child(4),
.table th:nth-child(5),
.table td:nth-child(5) {
    text-align: center;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.close-modal {
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #666;
    line-height: 1;
}

.close-modal:hover {
    color: #000;
}

.btn-cancel {
    background-color: #6c757d;
    color: white;
    border: none;
    cursor: pointer;
}

.btn-cancel:hover {
    background-color: #5a6268;
}


.modal-body {
    margin-bottom: 20px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    border: none;
    font-size: 14px;
}


.btn-delete {
    background-color: #dc3545;
    color: white;
    text-decoration: none;
}

.btn-cancel:hover {
    background-color: #5a6268;
}

.btn-delete:hover {
    background-color: #c82333;
}

/* Update the three dots button style */
.dropdown-toggle {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    padding: 5px 10px;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background: white;
    min-width: 120px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    z-index: 100;
}

.dropdown-menu a {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
}

.dropdown-menu a:hover {
    background-color: #f8f9fa;
}

.dropdown-menu i {
    margin-right: 8px;
}
</style>
