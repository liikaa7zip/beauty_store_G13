<?php if (isset($_SESSION['success'])): ?>
    
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>



<div class="customers-list">
    <h1>Customers</h1>

    <!-- Create Customer Form -->
    <h2>Add New Customer</h2>
    <form action="/customers/create" method="POST">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" required>
    </div>
    <div class="form-group">
        <label for="address">Unpaid Products</label>
        <input type="text" id="address" name="address" required>
    </div>
    <div class="form-group">
        <label for="total_debt">Initial Debt (optional)</label>
        <input type="number" id="total_debt" name="total_debt" step="0.01" value="0">
    </div>
    <button type="submit" class="btn btn-primary">Create Customer</button>
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
                <td><?php echo htmlspecialchars($customer['address']); ?></td>
                <td>
                    <div class="alt-dropdown-box">
                        <button class="alt-dropdown-toggle" type="button" onclick="toggleAltDropdown(this)">
                            Actions
                        </button>
                        <div class="alt-dropdown-menu">
                            <a href="/customers/view/<?= $customer['id'] ?>" class="alt-dropdown-item">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <a href="#" class="alt-dropdown-item text-danger" onclick="showModal(<?= $customer['id'] ?>)">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </td>

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
document.addEventListener('DOMContentLoaded', function () {
    // Handle dropdown toggle clicks
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle-btn');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.stopPropagation(); // Prevent event propagation
            const dropdownContent = this.nextElementSibling;

            // Close all other dropdowns first
            document.querySelectorAll('.dropdown-content').forEach(content => {
                if (content !== dropdownContent) {
                    content.style.display = 'none';
                }
            });

            // Toggle the current dropdown
            dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-content').forEach(content => {
            content.style.display = 'none';
        });
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

// Ensure the "Cancel" button and close button call the correct function
document.querySelectorAll('.btn-cancel, .close-modal').forEach(button => {
    button.addEventListener('click', function () {
        const modal = this.closest('.modal');
        if (modal) {
            modal.style.display = 'none';
        }
    });
});

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

// Only run this code on mobile devices
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a mobile device
    if (window.innerWidth <= 767) {
        // Process table for mobile view
        const table = document.querySelector('.table');
        if (table) {
            // Add data-label attributes to cells
            const headerCells = table.querySelectorAll('thead th');
            const headerTexts = Array.from(headerCells).map(cell => cell.textContent.trim());
            
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                
                // Get the name cell and actions cell
                const nameCell = cells[0];
                const actionsCell = cells[cells.length - 1];
                
                if (nameCell && actionsCell) {
                    // Get customer name
                    const customerNameText = nameCell.textContent.trim();
                    
                    // Clear the name cell content
                    nameCell.innerHTML = '';
                    
                    // Create customer name element
                    const customerName = document.createElement('div');
                    customerName.style.fontWeight = '600';
                    customerName.style.fontSize = '18px';
                    customerName.style.flex = '1';
                    customerName.textContent = customerNameText;
                    nameCell.appendChild(customerName);
                    
                    // Get the dropdown from actions cell
                    const dropdown = actionsCell.querySelector('.dropdown');
                    if (dropdown) {
                        // Clone the dropdown to preserve event listeners
                        const clonedDropdown = dropdown.cloneNode(true);
                        
                        // Style the dropdown for mobile
                        clonedDropdown.style.position = 'relative';
                        clonedDropdown.style.display = 'inline-block';
                        
                        // Add the dropdown to the name cell
                        nameCell.appendChild(clonedDropdown);
                        
                        // Re-attach event listeners to the cloned dropdown
                        const dropdownToggle = clonedDropdown.querySelector('.dropdown-toggle');
                        if (dropdownToggle) {
                            dropdownToggle.addEventListener('click', function(e) {
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
                        }
                    }
                }
                
                // Add data-label attributes to all cells
                cells.forEach((cell, index) => {
                    if (index < headerTexts.length) {
                        cell.setAttribute('data-label', headerTexts[index]);
                    }
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
        }
    }
});


function toggleAltDropdown(button) {
    var menu = button.nextElementSibling;
    menu.classList.toggle('show');

    // Optional: close other dropdowns
    document.addEventListener('click', function (e) {
        if (!button.parentElement.contains(e.target)) {
            menu.classList.remove('show');
        }
    }, { once: true });
}
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

/* Mobile-only responsive styles - only applies to screens below 768px */
@media screen and (max-width: 767px) {
    /* Hide table headers on mobile */
    .table thead {
        display: none;
    }
    
    /* Convert table to cards */
    .table, 
    .table tbody {
        display: block;
        width: 100%;
    }
    
    /* Style each row as a card */
    .table tr {
        display: block;
        background: white;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    /* Style each cell */
    .table td {
        display: block;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
    }
    
    /* Add labels to cells */
    .table td:before {
        content: attr(data-label);
        font-weight: 600;
        color: #495057;
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
    }
    
    /* Style customer name cell to include actions */
    .table td:first-child {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    /* Remove label from name cell */
    .table td:first-child:before {
        display: none;
    }
    
    /* Hide the original actions cell */
    .table td:last-child {
        display: none;
    }
}

/* NES Dropdown Styles */
.nes-dropdown {
    position: relative;
    display: inline-block;
}

.nes-dropdown .dropdown-toggle {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.nes-dropdown .dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 150px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    z-index: 1000;
    margin-top: 5px;
    padding: 8px 0;
}

.nes-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.2s;
    font-size: 14px;
}

.nes-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
}

.nes-dropdown .dropdown-item.text-danger {
    color: #dc3545;
}

.nes-dropdown .dropdown-item.text-danger:hover {
    background-color: #fff5f5;
}

.nes-dropdown .dropdown-item i {
    margin-right: 8px;
    font-size: 16px;
}

/* New Dropdown Styles */
.dropdown-container {
    position: relative;
    display: inline-block;
}

.dropdown-toggle-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.dropdown-toggle-btn:hover {
    background-color: #0056b3;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background: white;
    min-width: 150px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    z-index: 1000;
    margin-top: 5px;
    padding: 8px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 8px 16px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.2s;
    font-size: 14px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.dropdown-item.text-danger {
    color: #dc3545;
}

.dropdown-item.text-danger:hover {
    background-color: #fff5f5;
}

.dropdown-item i {
    margin-right: 8px;
    font-size: 16px;
}

.alt-dropdown-menu {
    display: none;
    position: absolute;
    background-color: #ffffff;
    min-width: 160px;
    padding: 8px 0;
    border-radius: 12px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    z-index: 100;
    margin-top: 8px;
    transition: opacity 0.2s ease, transform 0.2s ease;
    opacity: 0;
    transform: translateY(10px);
}

.alt-dropdown-menu.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.alt-dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    transition: background-color 0.2s ease, color 0.2s ease;
    border-radius: 8px;
}

.alt-dropdown-item i {
    font-size: 16px;
    color: #666;
    transition: color 0.2s ease;
}

.alt-dropdown-item:hover {
    background-color: #f0f0f5;
    color: #000;
}

.alt-dropdown-item:hover i {
    color: #000;
}


.alt-dropdown-toggle {
    background-color: #f7f7f7;
    color: #333;
    padding: 8px 14px;
    font-size: 14px;
    border: 1px solid #d0d0d0;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.alt-dropdown-toggle:hover {
    background-color: #e9ecef;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

</style>


