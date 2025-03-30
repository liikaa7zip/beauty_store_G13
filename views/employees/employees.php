<style>
    .emp-dropdown-menu {
        position: relative;
        display: inline-block;
    }

    .emp-dropdown-options {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        min-width: 150px;
    }

    .emp-dropdown-options .emp-dropdown-item {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        cursor: pointer;
    }

    .emp-dropdown-options .emp-dropdown-item:hover {
        background-color: #f5f5f5;
        color: #000;
    }

    .emp-dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
    }

    .emp-dropdown-toggle:focus {
        outline: none;
    }
</style>
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
                            <div class="emp-profile-image"></div>
                                <img src="<?= htmlspecialchars($employee['image']); ?>"
                                    onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/149/149071.png';"
                                    alt="Profile Image"
                                    width="50px"
                                    height="50px"
                                    class="rounded-circle">
                            </div>
                        </td>
                        <td class="emp-table-data" id="emp-data-name-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['username']) ?></td>
                        <td class="emp-table-data" id="emp-data-department-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['role']) ?></td>
                        <td class="emp-table-data" id="emp-data-hire-date-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars($employee['email']) ?></td>
                        <td class="emp-table-data" id="emp-data-contact-<?= htmlspecialchars($employee['id']) ?>"><?= htmlspecialchars(substr($employee['password'], 0, 5)) ?>...</td>


                        <td class="emp-table-data">
                            <div class="emp-dropdown-menu">
                                <button class="emp-dropdown-toggle btn btn-sm" onclick="toggleDropdown(this)">
                                    <span class="material-symbols-outlined">more_horiz</span>
                                </button>
                                <div class="emp-dropdown-options">
                                    <a href="/employees/edit/<?= htmlspecialchars($employee['id']) ?>" class="emp-dropdown-item">
                                        <span class="material-symbols-outlined">border_color</span> Edit
                                    </a>
                                    <a href="/employees/delete/<?= htmlspecialchars($employee['id']) ?>" class="emp-dropdown-item">
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




<script>
    // Function to toggle the dropdown visibility
    function toggleDropdown(button) {
        const dropdownOptions = button.nextElementSibling;
        const allDropdowns = document.querySelectorAll('.emp-dropdown-options');

        // Close all other dropdowns
        allDropdowns.forEach(option => {
            if (option !== dropdownOptions) {
                option.style.display = 'none';
            }
        });

        // Toggle the clicked dropdown
        dropdownOptions.style.display = dropdownOptions.style.display === 'block' ? 'none' : 'block';
    }

    // Close dropdown when clicking anywhere else on the page
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.emp-dropdown-options');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target) && !event.target.closest('.emp-dropdown-menu')) {
                dropdown.style.display = 'none';
            }
        });
    });


    document.querySelectorAll('.emp-dropdown-menu').forEach(dropdownMenu => {
        dropdownMenu.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    });
</script>