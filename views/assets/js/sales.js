// Wait for the DOM to fully load before running the script
document.addEventListener('DOMContentLoaded', function () {
    // Cache DOM elements to improve performance
    const salesSelect = document.querySelector('.main-content1 .sales-section select');
    const salesAmount = document.querySelector('.main-content1 .sales-section p');
    const salesBars = document.querySelectorAll('.main-content1 .sales-section .sales-chart .bar');
    const stockChartCanvas = document.getElementById('stockChart');
    const addNewBtn = document.querySelector('.main-content1 .popular-products1 .add-new-btn1');
    const productTableBody = document.querySelector('.main-content1 .popular-products1 table tbody');

    // Initialize Charts and Event Listeners
    initializeSalesSection();
    initializeStockChart();
    initializeProductManagement();

    /**
     * Initializes the Sales Section functionality
     */
    function initializeSalesSection() {
        if (!salesSelect || !salesAmount || !salesBars.length) {
            console.warn('Sales section elements not found.');
            return;
        }

        // Sample sales data for each month (replace with backend data if needed)
        const salesData = {
            'January 2023': { amount: 700215, barHeights: [80, 60, 40, 20] },
            'February 2023': { amount: 550000, barHeights: [70, 50, 30, 10] },
        };

        // Update sales amount and bar chart on selection
        salesSelect.addEventListener('change', function () {
            const selectedMonth = this.value;
            const data = salesData[selectedMonth];

            if (data) {
                salesAmount.textContent = `$${data.amount.toLocaleString()}`;
                salesBars.forEach((bar, index) => {
                    bar.style.height = `${data.barHeights[index] || 0}%`;
                });
            } else {
                salesAmount.textContent = '$0';
                salesBars.forEach(bar => bar.style.height = '0%');
            }
        });

        // Trigger change event on page load to set initial values
        salesSelect.dispatchEvent(new Event('change'));
    }

    /**
     * Initializes the Stock Levels Chart using Chart.js
     */
    function initializeStockChart() {
        if (!stockChartCanvas) {
            console.warn('Stock chart canvas not found.');
            return;
        }

        const stockData = {
            labels: ['Sukibushu', 'Pone', 'Clivina', 'Nivea'],
            datasets: [{
                label: 'Stock Levels',
                data: [120, 30, 150, 40],
                backgroundColor: '#ff4d94',
                borderColor: '#ff4d94',
                borderWidth: 1
            }]
        };

        new Chart(stockChartCanvas, {
            type: 'bar',
            data: stockData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Stock Quantity'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Products'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    /**
     * Initializes the Popular Products section functionality
     */
    function initializeProductManagement() {
        if (!addNewBtn || !productTableBody) {
            console.warn('Product management elements not found.');
            return;
        }

        // Add New Product Functionality
        addNewBtn.addEventListener('click', handleAddNewProduct);

        // Attach Edit and Delete listeners to existing rows
        document.querySelectorAll('.main-content1 .popular-products1 table tbody tr').forEach(row => {
            attachEditDeleteListeners(row);
        });
    }

    /**
     * Handles the Add New Product action
     */
    function handleAddNewProduct() {
        this.disabled = true;
        this.style.opacity = '0.6';
        const loadingIndicator = createLoadingIndicator(); // Add a loading spinner
        this.appendChild(loadingIndicator);

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" class="new-product-name" placeholder="Product Name" required></td>
            <td><input type="text" class="new-product-category" placeholder="Category" required></td>
            <td>
                <select class="new-product-status">
                    <option value="In stock">In stock</option>
                    <option value="Low stock">Low stock</option>
                </select>
            </td>
            <td>
                <button class="action-btn save-btn" title="Save product">💾</button>
                <button class="action-btn cancel-btn" title="Cancel">❌</button>
            </td>
        `;
        productTableBody.prepend(newRow);

        const saveBtn = newRow.querySelector('.save-btn');
        const cancelBtn = newRow.querySelector('.cancel-btn');

        saveBtn.addEventListener('click', () => handleSaveNewProduct(newRow));
        cancelBtn.addEventListener('click', () => handleCancelNewProduct(newRow, loadingIndicator));

        newRow.querySelector('.new-product-name').focus();
    }

    /**
     * Handles saving a new product
     * @param {HTMLTableRowElement} row - The table row containing the form
     */
    function handleSaveNewProduct(row) {
        const name = row.querySelector('.new-product-name').value.trim();
        const category = row.querySelector('.new-product-category').value.trim();
        const status = row.querySelector('.new-product-status').value;
        const statusClass = status.toLowerCase() === 'in stock' ? 'in-stock' : 'low-stock';

        if (name && category) {
            row.innerHTML = `
                <td>${name}</td>
                <td>${category}</td>
                <td><span class="status ${statusClass}">${status}</span></td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">✏️</button>
                    <button class="action-btn delete-btn" title="Delete">🗑️</button>
                </td>
            `;
            resetAddButton();
            attachEditDeleteListeners(row);
        } else {
            alert('Please fill in all required fields.');
            resetAddButton();
        }
    }

    /**
     * Handles canceling a new product addition
     * @param {HTMLTableRowElement} row - The table row to remove
     * @param {HTMLElement} loadingIndicator - The loading indicator to remove
     */
    function handleCancelNewProduct(row, loadingIndicator) {
        row.remove();
        resetAddButton(loadingIndicator);
    }

    /**
     * Resets the Add New Button state
     * @param {HTMLElement} [loadingIndicator] - Optional loading indicator to remove
     */
    function resetAddButton(loadingIndicator) {
        const addNewBtn = document.querySelector('.main-content1 .popular-products1 .add-new-btn1');
        addNewBtn.disabled = false;
        addNewBtn.style.opacity = '1';
        if (loadingIndicator) {
            loadingIndicator.remove();
        }
    }

    /**
     * Creates a loading indicator (spinner)
     * @returns {HTMLElement} - The loading spinner element
     */
    function createLoadingIndicator() {
        const spinner = document.createElement('span');
        spinner.style.cssText = 'margin-left: 10px; border: 2px solid #fff; border-top: 2px solid #000; border-radius: 50%; width: 16px; height: 16px; animation: spin 1s linear infinite;';
        return spinner;
    }

    /**
     * Attaches Edit and Delete listeners to a row
     * @param {HTMLTableRowElement} row - The table row to attach listeners to
     */
    function attachEditDeleteListeners(row) {
        const editBtn = row.querySelector('.edit-btn');
        const deleteBtn = row.querySelector('.delete-btn');

        editBtn.addEventListener('click', () => handleEditProduct(row));
        deleteBtn.addEventListener('click', () => handleDeleteProduct(row));
    }

    /**
     * Handles editing a product
     * @param {HTMLTableRowElement} row - The table row to edit
     */
    function handleEditProduct(row) {
        const name = row.children[0].textContent;
        const category = row.children[1].textContent;
        const status = row.children[2].textContent;

        row.innerHTML = `
            <td><input type="text" class="edit-product-name" value="${name}" required></td>
            <td><input type="text" class="edit-product-category" value="${category}" required></td>
            <td>
                <select class="edit-product-status">
                    <option value="In stock" ${status === 'In stock' ? 'selected' : ''}>In stock</option>
                    <option value="Low stock" ${status === 'Low stock' ? 'selected' : ''}>Low stock</option>
                </select>
            </td>
            <td>
                <button class="action-btn save-btn" title="Save changes">💾</button>
                <button class="action-btn cancel-btn" title="Cancel changes">❌</button>
            </td>
        `;

        const saveBtn = row.querySelector('.save-btn');
        const cancelBtn = row.querySelector('.cancel-btn');

        saveBtn.addEventListener('click', () => handleSaveEditedProduct(row));
        cancelBtn.addEventListener('click', () => handleCancelEdit(row, name, category, status));
    }

    /**
     * Handles saving an edited product
     * @param {HTMLTableRowElement} row - The table row being edited
     */
    function handleSaveEditedProduct(row) {
        const newName = row.querySelector('.edit-product-name').value.trim();
        const newCategory = row.querySelector('.edit-product-category').value.trim();
        const newStatus = row.querySelector('.edit-product-status').value;
        const newStatusClass = newStatus.toLowerCase() === 'in stock' ? 'in-stock' : 'low-stock';

        if (newName && newCategory) {
            row.innerHTML = `
                <td>${newName}</td>
                <td>${newCategory}</td>
                <td><span class="status ${newStatusClass}">${newStatus}</span></td>
                <td>
                    <button class="action-btn edit-btn" title="Edit">✏️</button>
                    <button class="action-btn delete-btn" title="Delete">🗑️</button>
                </td>
            `;
            attachEditDeleteListeners(row);
        } else {
            alert('Please fill in all required fields.');
        }
    }

    /**
     * Handles canceling an edit
     * @param {HTMLTableRowElement} row - The table row to revert
     * @param {string} name - Original product name
     * @param {string} category - Original product category
     * @param {string} status - Original product status
     */
    function handleCancelEdit(row, name, category, status) {
        const statusClass = status.toLowerCase() === 'in stock' ? 'in-stock' : 'low-stock';
        row.innerHTML = `
            <td>${name}</td>
            <td>${category}</td>
            <td><span class="status ${statusClass}">${status}</span></td>
            <td>
                <button class="action-btn edit-btn" title="Edit">✏️</button>
                <button class="action-btn delete-btn" title="Delete">🗑️</button>
            </td>
        `;
        attachEditDeleteListeners(row);
    }

    /**
     * Handles deleting a product
     * @param {HTMLTableRowElement} row - The table row to delete
     */
    function handleDeleteProduct(row) {
        if (confirm('Are you sure you want to delete this product?')) {
            row.remove();
        }
    }

    // Add CSS animation for spinner
    const styleSheet = document.createElement('style');
    styleSheet.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
    document.head.appendChild(styleSheet);
});