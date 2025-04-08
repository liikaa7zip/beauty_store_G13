<?php if (!empty($history)): ?>
    <div class="history-container">
        <h1>Category History</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Action</th>
                    <th>Performed By</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $record): ?>
                    <tr <?php if (!empty($record['user_id'])): ?>data-user-id="<?php echo htmlspecialchars($record['user_id']); ?>"<?php endif; ?>>
                        <td><?php echo htmlspecialchars($record['category_name']); ?></td>
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
        <h4>No Category History Found</h4>
        <p>There is no category history to display at the moment.</p>
    </div>
<?php endif; ?>

