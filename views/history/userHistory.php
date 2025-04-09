
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold">User History</h2>
            <p class="text-muted">View and manage system history records</p>
        </div>
    </div>
    <div class="dashboard-card">
        <!-- Search and Filter Bar -->
        <div class="filter-controls">
            <div class="search-container">
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="search-user-history" class="search-input" placeholder="Search by username, role, or product..." onkeyup="filterTable()">
                </div>
            </div>
            <div class="filter-group">
                <div class="filter-item">
                    <label for="rows-per-page" class="filter-label">Rows:</label>
                    <select id="rows-per-page" class="form-select filter-select" onchange="updatePagination()">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="status-filter" class="filter-label">Status:</label>
                    <select id="status-filter" class="form-select filter-select" onchange="filterTable()">
                        <option value="all">All</option>
                        <option value="active">Active</option>
                        <option value="logged-out">Logged Out</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="date-range-filter" class="filter-label">Date Range:</label>
                    <select id="date-range-filter" class="form-select filter-select" onchange="filterTable()">
                        <option value="all">All Time</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="history-type-filter" class="filter-label">History Type:</label>
                    <select id="history-type-filter" class="form-select filter-select">
                        <option value="product">Product</option>
                        <option value="category">Category</option>
                        <option value="sell">Sell</option>
                        <option value="promotion">Promotion</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- User Login History Table -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%;" onclick="sortTable(0)">
                            <div class="th-content">User Name</div>
                        </th>
                        <th scope="col" style="width: 12%;" onclick="sortTable(1)">
                            <div class="th-content">Role</div>
                        </th>
                        <th scope="col" style="width: 15%;" onclick="sortTable(3)">
                            <div class="th-content">Status</div>
                        </th>
                        <th scope="col" style="width: 20%;" onclick="sortTable(4)">
                            <div class="th-content">Login Time</div>
                        </th>
                        <th scope="col" style="width: 20%;" onclick="sortTable(5)">
                            <div class="th-content">Logout Time</div>
                        </th>
                        <th scope="col" style="width: 13%;">Duration</th>
                    </tr>
                </thead>
                <tbody id="historyTable">
                    <?php
                    date_default_timezone_set('Asia/Phnom_Penh');
                    if (!empty($history) && is_array($history)):
                        $now = new DateTime();
                        foreach ($history as $record):
                            $loginTime = new DateTime($record['login_time']);
                            $logoutTime = !empty($record['logout_time']) ? new DateTime($record['logout_time']) : null;
                            $duration = $logoutTime ? $logoutTime->diff($loginTime) : $now->diff($loginTime);
                    ?>
                            <tr data-user-id="<?php echo $record['user_id']; ?>">
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <?php echo strtoupper(substr($record['username'] ?? '?', 0, 1)); ?>
                                        </div>
                                        <div class="user-details">
                                            <?php echo htmlspecialchars($record['username'] ?? 'N/A'); ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge" data-role="<?php echo htmlspecialchars($record['role'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($record['role'] ?? 'N/A'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (empty($record['logout_time'])): ?>
                                        <span class="status-badge active">
                                            <i class="fas fa-circle status-icon"></i> Active
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">
                                            <i class="fas fa-power-off status-icon"></i> Logged Out
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="timestamp">
                                        <div class="datetime"><?php echo $loginTime->format('Y-m-d H:i:s'); ?></div>
                                        <div class="time-ago"><?php echo timeAgo($loginTime, $now); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <?php if (empty($record['logout_time'])): ?>
                                        <span class="text-warning">Still Active</span>
                                    <?php else: ?>
                                        <div class="timestamp">
                                            <div class="datetime"><?php echo $logoutTime->format('Y-m-d H:i:s'); ?></div>
                                            <div class="time-ago"><?php echo timeAgo($logoutTime, $now); ?></div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($logoutTime): ?>
                                        <span class="session-duration">
                                            <?php echo formatDuration($duration); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="session-duration active">
                                            <?php echo formatDuration($duration); ?>
                                            <span class="live-indicator"></span>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="no-data-row">
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-user-clock empty-icon"></i>
                                    <h4>No login history found</h4>
                                    <p>There are no records to display at this time</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mobile-view" id="mobile-view">
            <!-- Mobile cards will be populated by JavaScript -->
        </div>
        <div id="showing-entries" class="pagination-info mt-3">
            Showing 0 to 0 of 0 entries
        </div>
    </div>
</div>

<?php
function timeAgo($date, $now)
{
    $diff = $date->diff($now);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    }
    if ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    }
    if ($diff->d > 0) {
        if ($diff->d == 1) return 'yesterday';
        if ($diff->d < 7) return $diff->d . ' days ago';
        if ($diff->d < 14) return 'last week';
        if ($diff->d < 21) return '2 weeks ago';
        return round($diff->d / 7) . ' weeks ago';
    }
    if ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    }
    if ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    }
    if ($diff->s > 30) {
        return 'less than a minute ago';
    }
    return 'just now';
}

function formatDuration($diff)
{
    $parts = [];

    // More readable duration formatting
    if ($diff->d > 0) {
        $parts[] = $diff->d . 'D' . ($diff->d > 1 ? '' : '');
    }
    if ($diff->h > 0) {
        $parts[] = $diff->h . 'H' . ($diff->h > 1 ? '' : '');
    }
    if ($diff->i > 0) {
        $parts[] = $diff->i . 'M' . ($diff->i > 1 ? '' : '');
    }
    if ($diff->s > 0 && count($parts) < 2) {
        $parts[] = $diff->s . 'S' . ($diff->s > 1 ? '' : '');
    }

    if (empty($parts)) {
        return '0S';
    }

    // Join with commas and "and" for the last item
    if (count($parts) > 1) {
        $last = array_pop($parts);
        return implode(', ', $parts) . ' ' . $last;
    }

    return $parts[0];
}
?>



<script>
    // Global variables for table management
    let currentPage = 1;
    let rowsPerPage = 10;
    let sortColumn = -1;
    let sortDirection = 1;
    let tableData = [];
    let filteredData = [];

    // Initialize the table when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Set initial rows per page from select element
        rowsPerPage = parseInt(document.getElementById('rows-per-page').value);

        // Initialize table data and display
        initializeTable();
        updatePagination();

        // Set up event listeners
        setupEventListeners();
    });

    // Set up all event listeners for filters and sorting
    function setupEventListeners() {
        // Search input event
        document.getElementById('search-user-history').addEventListener('input', function() {
            currentPage = 1;
            filterTable();
        });

        // Filter select events
        document.getElementById('status-filter').addEventListener('change', filterTable);
        document.getElementById('date-range-filter').addEventListener('change', filterTable);
        document.getElementById('rows-per-page').addEventListener('change', function() {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            updatePagination();
        });

        // Add click events to table headers for sorting
        const headers = document.querySelectorAll('.data-table thead th');
        headers.forEach((header, index) => {
            header.addEventListener('click', () => sortTable(index));
        });
    }

    // Initialize table data
    function initializeTable() {
        const rows = document.querySelectorAll('#historyTable tr:not(.no-data-row)');
        tableData = Array.from(rows).map(row => {
            const cells = row.cells;
            const logoutText = cells[4].textContent.trim();
            const loginTimeStr = cells[3].querySelector('.datetime')?.textContent;
            const logoutTimeStr = cells[4].querySelector('.datetime')?.textContent;
            const usernameElement = cells[0].querySelector('.user-details');

            return {
                element: row,
                userId: row.getAttribute('data-user-id'),
                username: usernameElement ? usernameElement.textContent.trim().toLowerCase() : '',
                role: cells[1].textContent.trim().toLowerCase(),
                status: cells[2].textContent.toLowerCase().includes('active') ? 'active' : 'logged-out',
                loginTime: loginTimeStr ? new Date(loginTimeStr) : null,
                logoutTime: logoutText === 'Still Active' ? null : (logoutTimeStr ? new Date(logoutTimeStr) : null),
                sessionDuration: cells[5].textContent.trim().toLowerCase()
            };
        });

        // Initially, filteredData is the same as tableData
        filteredData = [...tableData];

        // Set up row click handlers
        setupRowClickHandlers();
    }

    // Set up click handlers for table rows
    function setupRowClickHandlers() {
        const rows = document.querySelectorAll('#historyTable tr[data-user-id]');
        const historyTypeFilter = document.getElementById('history-type-filter');

        rows.forEach(row => {
            row.addEventListener('click', function(event) {
                // Don't navigate if clicking on a link or button inside the row
                if (event.target.tagName === 'A' || event.target.tagName === 'BUTTON') {
                    return;
                }

                const userId = row.getAttribute('data-user-id');
                const historyType = historyTypeFilter.value;

                if (userId && historyType) {
                    window.location.href = `/history?type=${historyType}&user_id=${userId}`;
                }
            });
        });
    }

    // Filter table based on search and filter criteria
    function filterTable() {
        const searchInput = document.getElementById('search-user-history').value.toLowerCase();
        const statusFilter = document.getElementById('status-filter').value;
        const dateRangeFilter = document.getElementById('date-range-filter').value;
        const now = new Date();
        let startDate = null;

        // Set start date based on date range filter
        switch (dateRangeFilter) {
            case 'today':
                startDate = new Date(now);
                startDate.setHours(0, 0, 0, 0);
                break;
            case 'week':
                startDate = new Date(now);
                startDate.setDate(now.getDate() - now.getDay());
                startDate.setHours(0, 0, 0, 0);
                break;
            case 'month':
                startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                break;
            case 'all':
            default:
                startDate = null;
        }

        // Filter the data
        filteredData = tableData.filter(data => {
            // Search filter
            const matchesSearch = searchInput === '' ||
                data.username.includes(searchInput) ||
                data.role.includes(searchInput);

            // Status filter
            const matchesStatus = statusFilter === 'all' ||
                data.status === statusFilter;

            let matchesDateRange = true;
            if (startDate && data.loginTime) {
                matchesDateRange = data.loginTime >= startDate;
            }

            return matchesSearch && matchesStatus && matchesDateRange;
        });

        if (sortColumn >= 0) {
            sortTable(sortColumn, true); 
        } else {
            updateDisplay();
        }
    }

    function sortTable(columnIndex, preserveDirection = false) {
        if (!preserveDirection) {
            if (sortColumn === columnIndex) {
                sortDirection *= -1;
            } else {
                sortColumn = columnIndex;
                sortDirection = 1; 
            }
        }

        filteredData.sort((a, b) => {
            let valA, valB;

            switch (columnIndex) {
                case 0: 
                    valA = a.username;
                    valB = b.username;
                    break;
                case 1: 
                    valA = a.role;
                    valB = b.role;
                    break;
                case 2: 
                    valA = a.status;
                    valB = b.status;
                    break;
                case 3: 
                    valA = a.loginTime?.getTime() || 0;
                    valB = b.loginTime?.getTime() || 0;
                    break;
                case 4: 
                    valA = a.logoutTime?.getTime() || 0;
                    valB = b.logoutTime?.getTime() || 0;
                    break;
                case 5:
                    valA = a.sessionDuration;
                    valB = b.sessionDuration;
                    break;
                default:
                    return 0;
            }

            if (valA < valB) return -1 * sortDirection;
            if (valA > valB) return 1 * sortDirection;
            return 0;
        });

        updateDisplay();
    }

    function updateDisplay() {
        tableData.forEach(data => {
            data.element.style.display = 'none';
        });

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = filteredData.slice(start, end);

        paginatedData.forEach(data => {
            data.element.style.display = '';
        });

        const emptyState = document.querySelector('.no-data-row');
        if (emptyState) {
            emptyState.style.display = filteredData.length === 0 ? '' : 'none';
        }

        updatePaginationInfo();
    }

    function updatePaginationInfo() {
        const totalRows = filteredData.length;
        const pageCount = Math.ceil(totalRows / rowsPerPage) || 1;

        currentPage = Math.max(1, Math.min(currentPage, pageCount));

        const start = (currentPage - 1) * rowsPerPage + 1;
        const end = Math.min(currentPage * rowsPerPage, totalRows);

        const showingElement = document.getElementById('showing-entries');
        showingElement.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>Showing ${totalRows > 0 ? start : 0} to ${end} of ${totalRows} entries</div>
                <div class="pagination-controls">
                    ${generatePaginationControls(currentPage, pageCount)}
                </div>
            </div>
        `;

        addPaginationEventListeners();
    }

    // Generate pagination controls HTML
    function generatePaginationControls(currentPage, totalPages) {
        let html = '';

        html += `<button class="pagination-btn ${currentPage === 1 ? 'disabled' : ''}" data-page="prev">
            <i class="fas fa-chevron-left"></i>
        </button>`;

        const maxVisiblePages = 3; 
        let startPage, endPage;

        if (totalPages <= maxVisiblePages) {
            startPage = 1;
            endPage = totalPages;
        } else {
            const half = Math.floor(maxVisiblePages / 2);
            if (currentPage <= half) {
                startPage = 1;
                endPage = maxVisiblePages;
            } else if (currentPage + half >= totalPages) {
                startPage = totalPages - maxVisiblePages + 1;
                endPage = totalPages;
            } else {
                startPage = currentPage - half;
                endPage = currentPage + half;
            }
        }

        if (startPage > 1) {
            html += `<button class="pagination-btn" data-page="1">1</button>`;
            if (startPage > 2) {
                html += `<span class="pagination-ellipsis">...</span>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            html += `<button class="pagination-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<span class="pagination-ellipsis">...</span>`;
            }
            html += `<button class="pagination-btn" data-page="${totalPages}">${totalPages}</button>`;
        }

        html += `<button class="pagination-btn ${currentPage === totalPages ? 'disabled' : ''}" data-page="next">
            <i class="fas fa-chevron-right"></i>
        </button>`;

        return html;
    }

    function addPaginationEventListeners() {
        document.querySelectorAll('.pagination-btn').forEach(button => {
            button.addEventListener('click', function() {
                const totalPages = Math.ceil(filteredData.length / rowsPerPage) || 1;
                let newPage = currentPage;

                if (this.dataset.page === 'prev') {
                    newPage = Math.max(1, currentPage - 1);
                } else if (this.dataset.page === 'next') {
                    newPage = Math.min(totalPages, currentPage + 1);
                } else {
                    newPage = parseInt(this.dataset.page);
                }

                if (newPage !== currentPage) {
                    currentPage = newPage;
                    updateDisplay();
                }
            });
        });
    }

    function updatePagination() {
        currentPage = 1;
        updateDisplay();
    }

    function updateDisplay() {
        tableData.forEach(data => {
            data.element.style.display = 'none';
        });

        // Calculate pagination
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedData = filteredData.slice(start, end);

        // Show paginated rows for desktop
        paginatedData.forEach(data => {
            data.element.style.display = '';
        });

        // Render mobile cards
        renderMobileCards(paginatedData);

        // Handle empty state for desktop
        const emptyState = document.querySelector('.no-data-row');
        if (emptyState) {
            emptyState.style.display = filteredData.length === 0 ? '' : 'none';
        }

        // Update pagination info
        updatePaginationInfo();

        // Force correct display based on screen size
        adjustDisplayForScreenSize();
    }

    // New function to adjust display based on screen size
    function adjustDisplayForScreenSize() {
        const tableContainer = document.querySelector('.table-container');
        const mobileView = document.querySelector('.mobile-view');
        const isMobile = window.matchMedia('(max-width: 768px)').matches;

        if (isMobile) {
            tableContainer.style.display = 'none';
            mobileView.style.display = 'block';
        } else {
            tableContainer.style.display = 'block';
            mobileView.style.display = 'none';
        }
    }

    // Add resize listener
    window.addEventListener('resize', adjustDisplayForScreenSize);

    // Modified renderMobileCards with better mobile optimization
    function renderMobileCards(records) {
        const mobileView = document.getElementById('mobile-view');
        mobileView.innerHTML = '';

        if (records.length === 0) {
            mobileView.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-user-clock empty-icon"></i>
                    <h4>No login history found</h4>
                    <p>There are no records to display at this time</p>
                </div>
            `;
            return;
        }

        records.forEach(data => {
            const row = data.element;
            const cells = row.cells;

            const userInfo = cells[0].querySelector('.user-info');
            const avatar = userInfo.querySelector('.user-avatar').textContent.trim();
            const username = userInfo.querySelector('.user-details').textContent.trim();
            const role = cells[1].querySelector('.role-badge').textContent.trim();
            const isActive = cells[2].textContent.toLowerCase().includes('active');
            const loginTimeEl = cells[3].querySelector('.timestamp');
            const loginDateTime = loginTimeEl ? loginTimeEl.querySelector('.datetime').textContent : '';
            const loginTimeAgo = loginTimeEl ? loginTimeEl.querySelector('.time-ago').textContent : '';
            const logoutCell = cells[4];
            const isStillActive = logoutCell.textContent.includes('Still Active');
            const logoutTimeEl = logoutCell.querySelector('.timestamp');
            const logoutDateTime = logoutTimeEl ? logoutTimeEl.querySelector('.datetime').textContent : '';
            const logoutTimeAgo = logoutTimeEl ? logoutTimeEl.querySelector('.time-ago').textContent : '';
            const durationEl = cells[5].querySelector('.session-duration');
            const duration = durationEl ? durationEl.textContent.trim() : '';

            const card = document.createElement('div');
            card.className = 'mobile-card';
            card.innerHTML = `
                <div class="mobile-card-header">
                    <div class="user-info">
                        <div class="user-avatar">${avatar}</div>
                        <div>
                            <div class="fw-medium">${username}</div>
                            <span class="role-badge" data-role="${role.toLowerCase()}">${role}</span>
                        </div>
                    </div>
                    <span class="status-badge ${isActive ? 'active' : 'inactive'}">
                        <i class="fas fa-${isActive ? 'circle' : 'power-off'} status-icon"></i>
                        ${isActive ? 'Active' : 'Logged Out'}
                    </span>
                </div>
                <div class="mobile-card-body">
                    <div class="mobile-card-field">
                        <div class="mobile-card-label">Login</div>
                        <div class="mobile-card-value">${loginDateTime}</div>
                        <div class="time-ago">${loginTimeAgo}</div>
                    </div>
                    <div class="mobile-card-field">
                        <div class="mobile-card-label">Logout</div>
                        ${isStillActive 
                            ? '<span class="text-warning">Still Active</span>' 
                            : `<div class="mobile-card-value">${logoutDateTime}</div>
                               <div class="time-ago">${logoutTimeAgo}</div>`
                        }
                    </div>
                    <div class="mobile-card-field">
                        <div class="mobile-card-label">Duration</div>
                        <span class="session-duration ${isActive ? 'active' : ''}">
                            ${duration}
                            ${isActive ? '<span class="live-indicator"></span>' : ''}
                        </span>
                    </div>
                </div>
            `;

            const userId = row.getAttribute('data-user-id');
            if (userId) {
                card.addEventListener('click', function(event) {
                    if (event.target.tagName !== 'A' && event.target.tagName !== 'BUTTON') {
                        const historyType = document.getElementById('history-type-filter').value;
                        window.location.href = `/history?type=${historyType}&user_id=${userId}`;
                    }
                });
                card.style.cursor = 'pointer';
            }

            mobileView.appendChild(card);
        });
    }

    // Call adjustDisplayForScreenSize on initial load
    document.addEventListener('DOMContentLoaded', function() {
        initializeTable();
        updatePagination();
        setupEventListeners();
        adjustDisplayForScreenSize();
    });
</script>