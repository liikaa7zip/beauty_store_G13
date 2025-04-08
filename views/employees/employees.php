<h2 id="user-management" style="margin-bottom: 1.5rem; color: var(--text-color);">Users Management</h2>

<!-- <div class="current-user-info" style="margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-radius: 8px;">
    <p style="margin: 0;">
        
        <span class="badge" style="
            background: <?= $currentUser['role'] === 'admin' ? '#e3f2fd' : '#e8f5e9' ?>; 
            color: <?= $currentUser['role'] === 'admin' ? '#1976d2' : '#388e3c' ?>;
            padding: 4px 8px;
            border-radius: 12px;
            margin-left: 8px;
        ">
            <?= ucfirst(htmlspecialchars($currentUser['role'])) ?>  
        </span>
    </p>
</div> -->

<div class="emp-employee-section" id="emp-employee-section">
    <header class="emp-employee-header" id="emp-employee-header">
        <div class="emp-header-left">
            <input type="text" class="emp-search-employee" id="emp-search-employee" placeholder="Search by name, email, or role...">
        </div>
        <div class="emp-header-right emp-action-buttons">
            <a href="/employees/create" class="emp-add-employee-btn btn btn-primary">
                <i class="fas fa-plus-circle" style="margin-right: 0.25rem;"></i> Add User
            </a>
        </div>
    </header>

    <table class="emp-employee-list-table" id="emp-employee-list-table">
        <thead class="emp-table-header" id="emp-table-header">
            <tr>
                <th class="emp-table-heading" id="emp-col-name">Profile</th>
                <th class="emp-table-heading" id="emp-col-name">Name</th>
                <th class="emp-table-heading" id="emp-col-department">Role</th>
                <th class="emp-table-heading" id="emp-col-hire-date">Email</th>
                <th class="emp-table-heading" id="emp-col-contact">Password</th>
                <th class="emp-table-heading" id="emp-col-actions">Actions</th>
            </tr>
        </thead>
        <tbody class="emp-table-body" id="emp-table-body">
            <?php
            if (is_array($employees) && count($employees) > 0) {
                foreach ($employees as $employee): ?>
                    <tr class="emp-table-row" id="emp-row-<?= htmlspecialchars($employee['id']) ?>">
                        <td class="emp-table-data" id="emp-data-contact-<?= htmlspecialchars($employee['id']) ?>">
                            <div class="emp-profile-image">
                                <img src="<?= htmlspecialchars($employee['image']); ?>"
                                    onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/149/149071.png';"
                                    alt="Profile Image"
                                    width="50"
                                    height="50"
                                    loading="lazy">
                            </div>
                        </td>
                        <td class="emp-table-data" id="emp-data-name-<?= htmlspecialchars($employee['id']) ?>">
                            <?= htmlspecialchars($employee['username']) ?>
                        </td>
                        <td class="emp-table-data" id="emp-data-department-<?= htmlspecialchars($employee['id']) ?>">
                            <span class="emp-role-badge" style="
                                background: <?= $employee['role'] === 'Admin' ? '#e3f2fd' : '#e8f5e9'; ?>;
                                color: <?= $employee['role'] === 'Admin' ? '#1976d2' : '#388e3c'; ?>;
                                padding: 0.25rem 0.5rem;
                                border-radius: 12px;
                                font-size: 0.8rem;
                                font-weight: 500;
                            ">
                                <?= htmlspecialchars($employee['role']) ?>
                            </span>
                        </td>
                        <td class="emp-table-data" id="emp-data-hire-date-<?= htmlspecialchars($employee['id']) ?>">
                            <?= htmlspecialchars($employee['email']) ?>
                        </td>
                        <td class="emp-table-data" id="emp-data-contact-<?= htmlspecialchars($employee['id']) ?>">
                            <span style="font-family: monospace;"><?= htmlspecialchars(substr($employee['password'], 0, 5)) ?>•••••</span>
                        </td>
                        <td class="emp-table-data">
                            <!-- <div class="emp-dropdown-menu">
                                <button class="emp-dropdown-toggle btn btn-sm" onclick="toggleDropdown(this)">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                                <div class="emp-dropdown-options">
                                    <a href="/employees/edit/<?= htmlspecialchars($employee['id']) ?>" class="emp-dropdown-item">
                                        <span class="material-symbols-outlined">edit</span> Edit
                                    </a>
                                    <a href="/employees/delete/<?= htmlspecialchars($employee['id']) ?>" class="emp-dropdown-item">
                                        <span class="material-symbols-outlined">delete</span> Delete
                                    </a>
                                </div>
                            </div> -->

                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button">
                                    &#x22EE; <!-- Vertical Ellipsis -->
                                </button>
                                <div class="dropdown-menu">
                                    <a class="text-edit" href="/employees/edit/<?= htmlspecialchars($employee['id']) ?>" >
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a class="text-danger"  href="/employees/delete/<?= htmlspecialchars($employee['id']) ?>" >
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
            <?php endforeach;
            } else {
                echo '<tr><td colspan="6" style="text-align: center; padding: 2rem; color: #6c757d;">No users found. Click "Add User" to create a new one.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Search function for employee table
    function searchEmployees() {
        const searchInput = document.getElementById('emp-search-employee');
        const searchTerm = searchInput.value.toLowerCase().trim();
        const tableRows = document.querySelectorAll('.emp-table-body .emp-table-row');
        let hasVisibleRows = false;

        tableRows.forEach(row => {
            // Skip the empty state row
            if (row.querySelector('td[colspan]')) {
                return;
            }

            const name = row.querySelector('[id^="emp-data-name-"]')?.textContent.toLowerCase() || '';
            const role = row.querySelector('[id^="emp-data-department-"]')?.textContent.toLowerCase() || '';
            const email = row.querySelector('[id^="emp-data-hire-date-"]')?.textContent.toLowerCase() || '';

            const matches = name.includes(searchTerm) ||
                role.includes(searchTerm) ||
                email.includes(searchTerm);

            row.style.display = matches ? '' : 'none';
            if (matches) hasVisibleRows = true;
        });

        // Handle empty state
        const emptyStateRow = document.querySelector('.emp-table-body tr td[colspan]')?.parentElement;
        if (emptyStateRow) {
            emptyStateRow.style.display = hasVisibleRows || searchTerm === '' ? 'none' : '';
        }
    }

    // Initialize search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('emp-search-employee');

        // Search on input change with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(searchEmployees, 300);
        });

        // Also search when pressing Enter
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                searchEmployees();
            }
        });

        // Initial search to handle any pre-filled search terms
        searchEmployees();
    });

    // Dropdown functionality
    function toggleDropdown(button) {
        const dropdownOptions = button.nextElementSibling;
        const isShowing = dropdownOptions.classList.contains('show');

        // Close all dropdowns first
        document.querySelectorAll('.emp-dropdown-options').forEach(dropdown => {
            dropdown.classList.remove('show');
        });

        // Toggle the clicked dropdown if it wasn't already showing
        if (!isShowing) {
            dropdownOptions.classList.add('show');

            // Position the dropdown to prevent overflow
            const dropdownRect = dropdownOptions.getBoundingClientRect();
            const viewportHeight = window.innerHeight;

            if (dropdownRect.bottom > viewportHeight) {
                dropdownOptions.style.top = 'auto';
                dropdownOptions.style.bottom = '100%';
            }
        }

        // Stop propagation to prevent immediate document click
        event.stopPropagation();
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.emp-dropdown-options').forEach(dropdown => {
            dropdown.classList.remove('show');
        });
    });

    // Prevent dropdown from closing when clicking inside
    document.querySelectorAll('.emp-dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });

    // Close dropdown when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('.emp-dropdown-options').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        }
    });
</script>
