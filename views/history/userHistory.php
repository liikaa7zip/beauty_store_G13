<h2 id="user-management" class="dashboard-section-title">User Login History</h2>
<div class="dashboard-card">

    <!-- Search and Filter Bar -->
    <div class="filter-controls">
        <div class="search-container">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="search-user-history" class="search-input" placeholder="Search by username, role, or IP..." onkeyup="filterTable()">
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
        </div>
    </div>


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
                    <th scope="col" style="width: 13%;">Session Duration</th>
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
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <?php echo strtoupper(substr($record['username'] ?? '?', 0, 1)); ?>
                                    </div>
                                    <div class="user-details">
                                        <span class="username"><?php echo htmlspecialchars($record['username'] ?? 'N/A'); ?></span>
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

    <!-- Pagination -->
    <div class="table-footer">
        <div class="showing-entries" id="showing-entries">
            Showing 1 to 10 of <?php echo count($history); ?> entries
        </div>
    </div>
</div>

<?php
function timeAgo($date, $now) {
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

function formatDuration($diff) {
    $parts = [];
    
    // More readable duration formatting
    if ($diff->d > 0) {
        $parts[] = $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
    }
    if ($diff->h > 0) {
        $parts[] = $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
    }
    if ($diff->i > 0) {
        $parts[] = $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
    }
    if ($diff->s > 0 && count($parts) < 2) {
        $parts[] = $diff->s . ' second' . ($diff->s > 1 ? 's' : '');
    }
    
    if (empty($parts)) {
        return '0 seconds';
    }
    
    // Join with commas and "and" for the last item
    if (count($parts) > 1) {
        $last = array_pop($parts);
        return implode(', ', $parts) . ' and ' . $last;
    }
    
    return $parts[0];
}
?>

<script>
    let currentPage = 1;
    let rowsPerPage = parseInt(document.getElementById('rows-per-page').value);
    let sortColumn = -1;
    let sortDirection = 1;
    let tableData = [];

    document.addEventListener('DOMContentLoaded', function() {
        initializeTable();
        updatePagination();
    });

    function initializeTable() {
        const rows = document.querySelectorAll('#historyTable tr:not(.no-data-row)');
        tableData = Array.from(rows).map(row => {
            const logoutText = row.cells[4].textContent.trim();
            const loginTimeStr = row.cells[3].querySelector('.datetime')?.textContent;
            const logoutTimeStr = row.cells[4].querySelector('.datetime')?.textContent;
            
            return {
                element: row,
                username: row.cells[0].querySelector('.username').textContent.toLowerCase(),
                role: row.cells[1].textContent.toLowerCase(),
                status: row.cells[2].textContent.toLowerCase().includes('active') ? 'active' : 'logged-out',
                loginTime: loginTimeStr ? new Date(loginTimeStr) : null,
                logoutTime: logoutText === 'Still Active' ? null : (logoutTimeStr ? new Date(logoutTimeStr) : null),
                sessionDuration: row.cells[5].textContent.trim().toLowerCase()
            };
        });
    }

    function filterTable() {
        const searchInput = document.getElementById('search-user-history').value.toLowerCase();
        const statusFilter = document.getElementById('status-filter').value;
        const dateRangeFilter = document.getElementById('date-range-filter').value;
        const now = new Date();
        let startDate = null;

        // Set start date based on date range filter
        switch(dateRangeFilter) {
            case 'today':
                startDate = new Date(now);
                startDate.setHours(0, 0, 0, 0);
                break;
            case 'week':
                startDate = new Date(now);
                startDate.setDate(now.getDate() - now.getDay()); // Start of week (Sunday)
                startDate.setHours(0, 0, 0, 0);
                break;
            case 'month':
                startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                break;
        }

        let visibleCount = 0;

        tableData.forEach(data => {
            const matchesSearch = data.username.includes(searchInput) || 
                                data.role.includes(searchInput);
            const matchesStatus = statusFilter === 'all' || 
                                data.status === statusFilter;
            const matchesDateRange = dateRangeFilter === 'all' || 
                                   (data.loginTime && (!startDate || data.loginTime >= startDate));

            if (matchesSearch && matchesStatus && matchesDateRange) {
                data.element.style.display = '';
                visibleCount++;
            } else {
                data.element.style.display = 'none';
            }
        });

        // Handle empty state
        const emptyState = document.querySelector('.no-data-row');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? '' : 'none';
        }

        // Reset to first page when filtering
        currentPage = 1;
        updatePagination(visibleCount);
    }

    function updatePagination(totalVisible) {
        rowsPerPage = parseInt(document.getElementById('rows-per-page').value);
        const totalRows = totalVisible || tableData.filter(data => data.element.style.display !== 'none').length;
        const pageCount = Math.ceil(totalRows / rowsPerPage) || 1;
        
        // Ensure current page is within bounds
        currentPage = Math.max(1, Math.min(currentPage, pageCount));

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        let visibleIndex = 0;

        // Show/hide rows based on pagination
        tableData.forEach(data => {
            if (data.element.style.display !== 'none') {
                data.element.style.display = (visibleIndex >= start && visibleIndex < end) ? '' : 'none';
                visibleIndex++;
            }
        });

        // Update showing entries text
        const showingEnd = Math.min(end, totalRows);
        document.getElementById('showing-entries').textContent = 
            `Showing ${totalRows > 0 ? start + 1 : 0} to ${showingEnd} of ${totalRows} entries`;
    }

    function sortTable(columnIndex) {
        // Toggle sort direction if clicking the same column
        if (sortColumn === columnIndex) {
            sortDirection *= -1;
        } else {
            sortColumn = columnIndex;
            sortDirection = 1;
        }

        tableData.sort((a, b) => {
            let valA, valB;
            
            switch(columnIndex) {
                case 0: // Username
                    valA = a.username;
                    valB = b.username;
                    break;
                case 1: // Role
                    valA = a.role;
                    valB = b.role;
                    break;
                case 3: // Status
                    valA = a.status;
                    valB = b.status;
                    break;
                case 4: // Login Time
                    valA = a.loginTime?.getTime() || 0;
                    valB = b.loginTime?.getTime() || 0;
                    break;
                case 5: // Logout Time
                    valA = a.logoutTime?.getTime() || 0;
                    valB = b.logoutTime?.getTime() || 0;
                    break;
                case 6: // Session Duration
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

        // Re-apply pagination after sorting
        updatePagination();
    }
</script>
<style>
    .search-input {
    padding-left: 40px;
    padding-right: 40px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    height: 40px;
    transition: all 0.2s;
}
.table-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}
</style>
