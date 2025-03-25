<!-- User Management Section -->
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
                <th class="emp-table-heading" id="emp-col-contact">Password</th>
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
                        <td class="emp-table-data" id="emp-data-contact-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['password']) ?></td>
                        <td class="emp-table-data" id="emp-data-status-<?= htmlspecialchars($employee['id']) ?>" data-status="<?= htmlspecialchars(strtolower($employee['status'])) ?>">
                            <?= htmlspecialchars($employee['status']) ?>
                        </td>
                        <td class="emp-table-data">
                            <div class="emp-dropdown-menu">
                                <button class="emp-dropdown-toggle btn btn-sm" onclick="toggleDropdown(this)">
                                <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                            <div class="emp-dropdown-options">
                            <a href="#" class="emp-dropdown-item">
                                <span class="material-symbols-outlined">border_color</span> Edit
                            </a>
                            <a href="#" class="emp-dropdown-item">
                                <span class="material-symbols-outlined">delete</span> Delete
                            </a>
                            </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach;
            } else {
                echo "<tr><td colspan='5'>No employees found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



<!-- JavaScript for dropdown functionality -->
<script>
    // Function to toggle the dropdown visibility
function toggleDropdown(button) {
    var dropdownOptions = button.nextElementSibling;
    var allDropdowns = document.querySelectorAll('.emp-dropdown-options');

    // Close all other dropdowns
    allDropdowns.forEach(function(option) {
        if (option !== dropdownOptions) {
            option.style.display = 'none';
        }
    });

    // Toggle the clicked dropdown
    if (dropdownOptions.style.display === 'none') {
        dropdownOptions.style.display = 'block';
    } else {
        dropdownOptions.style.display = 'none';
    }
}

// Function to close dropdown when clicking anywhere else on the page
document.addEventListener('click', function(event) {
    var dropdowns = document.querySelectorAll('.emp-dropdown-options');
    dropdowns.forEach(function(dropdown) {
        if (!dropdown.contains(event.target) && !event.target.closest('.emp-dropdown-menu')) {
            dropdown.style.display = 'none';
        }
    });
});

// Prevent the event from propagating when the user clicks inside the dropdown
document.querySelectorAll('.emp-dropdown-menu').forEach(function(dropdownMenu) {
    dropdownMenu.addEventListener('click', function(event) {
        event.stopPropagation();  // Prevent the event from bubbling up to the document
    });
});

</script>


