<div class="employee-container" id="employee-container">
        <header class="header" id="employee-header">
            <div class="header-left">
                <input type="text" class="search-box" id="search-employee" placeholder="Search Employee">
            </div>
            <div class="header-right">
                <button class="add-btn" id="add-employee">Add <i class="fas fa-plus-circle"></i></button>
                <button class="import-btn" id="import-employee">Import <i class="fas fa-file-import"></i></button>

            </div>
        </header>
        <table class="employee-table" id="employee-table">
            <thead class="table-header" id="table-header">
                <tr>
                    <th class="table-heading" id="col-name">Name</th>
                    <th class="table-heading" id="col-department">Role</th>
                    <th class="table-heading" id="col-contact">Contact</th>
                    <th class="table-heading" id="col-hire-date">Status</th>
                    <th class="table-heading" id="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body" id="table-body">
                <?php
                // Ensure $employees is an array
                if (is_array($employees) || is_object($employees)) {
                    foreach ($employees as $employee): ?>
                        <tr class="table-row" id="row-<?= $employee['id'] ?>">
                            <td class="table-data" id="data-name-<?= $employee['id'] ?>"><?= $employee['username'] ?></td>
                            <td class="table-data" id="data-department-<?= $employee['id'] ?>"><?= $employee['role'] ?></td>
                            <td class="table-data" id="data-contact-<?= $employee['id'] ?>"><?= $employee['contact'] ?></td>
                                <td class="table-data" id="data-requests-<?= $employee['id'] ?>"><?= $employee['status'] ?></td>
                        </tr>
                    <?php endforeach;
                } else {
                    echo "No employees found.";
                }
                ?>
            </tbody>
        </table>
    </div>