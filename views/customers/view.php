<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message"><?= $_SESSION['success'] ?></div>
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
        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none; font-size: 20px;">
            &#x22EE; <!-- Vertical Ellipsis -->
        </button>
        <ul class="dropdown-menu shadow-sm" style="min-width: 120px; border-radius: 8px;">
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/customers/view/<?= $customer['id'] ?>">
                    <i class="bi bi-eye me-2"></i> View
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center" href="/customers/edit/<?= $customer['id'] ?>">
                    <i class="bi bi-pencil me-2"></i> Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger d-flex align-items-center" href="/customers/delete/<?= $customer['id'] ?>">
                    <i class="bi bi-trash me-2"></i> Delete
                </a>
            </li>
        </ul>
    </div>
</td>



            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
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

</style>
