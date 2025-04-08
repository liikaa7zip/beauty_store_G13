<?php if (!empty($history)): ?>
    <div class="history-container">
        <h1>Product History for Session</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Action</th>
                    <th>Performed By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($record['action']); ?></td>
                        <td><?php echo htmlspecialchars($record['performed_by']); ?></td>
                        <td><?php echo htmlspecialchars($record['date']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <h4>No Product History Found for This Session</h4>
        <p>There is no product history to display for the selected session.</p>
    </div>
<?php endif; ?>


