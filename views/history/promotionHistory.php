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
                        <td style="text-transform: capitalize;"><?php echo htmlspecialchars($record['action']); ?></td>
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
<style>
.history-container {
    margin: 20px;
    overflow-x: auto; /* For horizontal scrolling on very small screens */
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.data-table th,
.data-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.data-table th {
    background-color: #f5f5f5;
    font-weight: 600;
}

/* Responsive styles */
@media screen and (max-width: 768px) {
    .data-table thead {
        display: none; /* Hide headers on mobile */
    }

    .data-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .data-table td {
        display: block;
        text-align: right;
        padding: 8px;
        font-size: 0.9em;
        border-bottom: 1px solid #eee;
      
    }

    .data-table td:last-child {
        border-bottom: none;
    }

    /* Add data labels using pseudo-elements */
    .data-table td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
        color: #666;
    }

    /* Specific labels for each column */
    .data-table td:nth-child(1)::before { content: "Product Name: "; }
    .data-table td:nth-child(2)::before { content: "Action: "; }
    .data-table td:nth-child(3)::before { content: "Performed By: "; }
    .data-table td:nth-child(4)::before { content: "Date: "; }
}

/* Empty state styling */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.empty-state h4 {
    margin-bottom: 0.5rem;
}

@media screen and (max-width: 768px) {
    .history-container {
        margin: 10px;
    }
    
    .empty-state {
        padding: 1rem;
        font-size: 0.9em;
    }
}
</style>