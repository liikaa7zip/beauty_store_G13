<!-- In customers/detail.php -->

<?php if (isset($customer)): ?>
    <div class="customer-details-container">
        <h2>Customer Details</h2>
        <div class="customer-info">
            <p>Name: <?= htmlspecialchars($customer['name']) ?></p>
            <p>Phone: <?= htmlspecialchars($customer['phone']) ?></p>
            <p>Address: <?= htmlspecialchars($customer['address']) ?></p>
            <p>Total Debt: $<?= number_format($customer['total_debt'], 2) ?></p>
        </div>

        <h3>Unpaid Products</h3>
        <?php if (!empty($unpaidProducts)): ?>
            <ul class="unpaid-product-list">
                <?php foreach ($unpaidProducts as $product): ?>
                    <li>
                        <?= htmlspecialchars($product['name']) ?> - 
                        <?= $product['quantity'] ?> x $<?= number_format($product['price'], 2) ?> 
                        <br>
                        <small>Date: <?= $product['sale_date'] ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="total-unpaid-info">
                Total Unpaid: $<?= number_format(array_sum(array_column($unpaidProducts, 'price')), 2) ?>
            </div>
        <?php else: ?>
            <p>No unpaid products.</p>
        <?php endif; ?>

        <!-- Payment Form -->
        <div class="payment-form-container">
            <h2>Make Payment</h2>
            <form method="post" action="/customers/pay" class="payment-form">
                <input type="hidden" name="customer_id" value="<?= $customer['id'] ?>">
                <div class="payment-form-group">
                    <label for="payment_amount">Payment Amount</label>
                    <input type="number" 
                        name="payment_amount" 
                        id="payment_amount" 
                        required 
                        min="0.01" 
                        max="<?= $customer['total_debt'] ?>" 
                        step="0.01">
                </div>
                <button type="submit" class="payment-submit-button">Make Payment</button>
            </form>
        </div>

    </div>
<?php else: ?>
    <p>Customer not found.</p>
<?php endif; ?>
