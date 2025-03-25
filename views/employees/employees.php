<h2 id="user-management">Users Management</h2>
    <div class="emp-employee-section" id="emp-employee-section">
        <header class="emp-employee-header" id="emp-employee-header">
            <div class="emp-header-left">
                <input type="text" class="emp-search-employee" id="emp-search-employee" placeholder="Search Employee">
            </div>
            <div class="emp-header-right emp-action-buttons">
                <a href="/employees/create" class="emp-add-employee-btn btn-primary">Add <i class="fas fa-plus-circle"></i></a>
            </div>
        </header>

        <table class="emp-employee-list-table" id="emp-employee-list-table">
            <thead class="emp-table-header" id="emp-table-header">
                <tr>
                    <th class="emp-table-heading" id="emp-col-name">Name</th>
                    <th class="emp-table-heading" id="emp-col-department">Role</th>
                    <th class="emp-table-heading" id="emp-col-contact">Contact</th>
                    <th class="emp-table-heading" id="emp-col-hire-date">Status</th>
                    <th class="emp-table-heading" id="emp-col-actions">Actions</th>
                </tr>
            </thead>
            <tbody class="emp-table-body" id="emp-table-body">
                <?php
                if (is_array($employees) && count($employees) > 0) {
                    foreach ($employees as $employee): ?>
                        <tr class="emp-table-row" id="emp-row-<?= htmlspecialchars($employee['id']) ?>">
                            <td class="emp-table-data" id="emp-data-name-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['username']) ?></td>
                            <td class="emp-table-data" id="emp-data-department-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['role']) ?></td>
                            <td class="emp-table-data" id="emp-data-contact-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['contact']) ?></td>
                            <td class="emp-table-data" id="emp-data-status-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['status']) ?></td>
                            <td class="emp-table-data" id="emp-data-actions-<?= htmlspecialchars($employee['id']) ?>"></td>
                        </tr>
                    <?php endforeach;
                } else {
                    echo "<tr><td colspan='5'>No employees found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>