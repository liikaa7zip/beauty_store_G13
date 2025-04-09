<?php if (!empty($history)): ?>
    <div class="history-container">
        <h1>Sale History</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Quantity</th>
                    <th>Performed By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($record['amount']); ?></td>
                        <td><?php echo htmlspecialchars($record['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($record['performed_by']); ?></td>
                        <td><?php echo htmlspecialchars($record['sale_date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <h4>No Sale History Found</h4>
        <p>There is no sale history to display at the moment.</p>
    </div>
<?php endif; ?>