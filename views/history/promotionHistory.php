<?php if (!empty($history)): ?>
    <div class="history-container">
        <h1>Promotion History</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Promotion Name</th>
                    <th>Action</th>
                    <th>Performed By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['promotion_name']); ?></td>
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
        <h4>No Promotion History Found</h4>
        <p>There is no promotion history to display at the moment.</p>
    </div>
<?php endif; ?>