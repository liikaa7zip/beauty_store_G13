function triggerImport() {
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.xlsx, .csv';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    fileInput.click();

    fileInput.onchange = function(e) {
        const file = e.target.files[0];
        if (!file) {
            document.body.removeChild(fileInput);
            return;
        }

        const toast = new bootstrap.Toast(document.getElementById('notification'));
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = `${(file.size / 1024).toFixed(2)} KB`;
        document.getElementById('status').textContent = 'Validating...';
        toast.show();

        const reader = new FileReader();
        reader.onload = function(event) {
            try {
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Check the first sheet
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Expected column headers (excluding Actions)
                const expectedHeaders = ['Name', 'Stock', 'Category', 'Status'];
                const headers = XLSX.utils.sheet_to_json(worksheet, { header: 1 })[0] || [];

                // Validate headers
                const missingHeaders = expectedHeaders.filter(header => !headers.includes(header));
                if (missingHeaders.length > 0) {
                    document.getElementById('status').textContent = `Error: Missing headers: ${missingHeaders.join(', ')}`;
                    document.body.removeChild(fileInput);
                    return;
                }

                // Check if there’s data beyond headers
                const jsonData = XLSX.utils.sheet_to_json(worksheet);
                if (jsonData.length <= 0) { // No data rows (excluding header)
                    document.getElementById('status').textContent = 'Error: No data rows found';
                    document.body.removeChild(fileInput);
                    return;
                }

                // If validation passes, proceed with upload
                document.getElementById('status').textContent = 'Processing...';
                const formData = new FormData();
                formData.append('file', file);

                fetch('/inventory/import/import', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('status').textContent = 'Done';
                        console.log('Import successful:', data.message);
                        location.reload(); // Reload to refresh table with new data
                    } else {
                        document.getElementById('status').textContent = 'Error: ' + data.message;
                        console.error('Import failed:', data.message);
                    }
                })
                .catch(error => {
                    document.getElementById('status').textContent = 'Error: Import failed - ' + error.message;
                    console.error('Fetch error:', error);
                });
            } catch (error) {
                document.getElementById('status').textContent = 'Error: Invalid file format - ' + error.message;
                console.error('File reading error:', error);
            }
            document.body.removeChild(fileInput);
        };reader.onerror = function() {
            document.getElementById('status').textContent = 'Error: Failed to read file';
            document.body.removeChild(fileInput);
        };

        reader.readAsArrayBuffer(file);
    };
}






/*export*/
function exportToExcel() {
    try {
        console.log('Export button clicked');

        // Try to get the table element by its ID
        const table = document.getElementById("productTable");

        let wb;

        if (table) {
            // If the table exists, convert table to worksheet and exclude Actions column
            const rows = table.getElementsByTagName('tr');
            const data = [];

            // Process header row, excluding Actions
            const headerRow = Array.from(rows[0].getElementsByTagName('th'))
                .map(th => th.textContent)
                .filter((header, index) => index < 4); // Exclude the last column (Actions)
            data.push(headerRow);

            // Process data rows, excluding Actions
            for (let i = 1; i < rows.length; i++) {
                const cells = Array.from(rows[i].getElementsByTagName('td'))
                    .map(td => td.textContent)
                    .filter((cell, index) => index < 4); // Exclude the last column (Actions)
                data.push(cells);
            }

            // Create worksheet from processed data
            const ws = XLSX.utils.aoa_to_sheet(data);
            wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            // Check if the table has data beyond the header
            if (rows.length <= 1) {
                alert('No data in the table! Exporting empty template.');
                const minimalData = [["Name", "Stock", "Category", "Status"]];
                const minimalWs = XLSX.utils.aoa_to_sheet(minimalData);
                wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, minimalWs, "Sheet1");
            }
            console.log('Table data exported to Excel (Actions excluded)');
        } else {
            // If the table doesn't exist, export a minimal template without Actions
            const minimalData = [["Name", "Stock", "Category", "Status"]];
            const ws = XLSX.utils.aoa_to_sheet(minimalData);
            wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            console.warn('No table found. Exported empty template.');
        }

        // Generate Excel file and trigger download
        XLSX.writeFile(wb, "products_export.xlsx");
        console.log('Export to Excel completed');
    } catch (e) {
        console.error("Export failed:", e);
        alert("Error exporting to Excel. Check console for details.");
    }
}

// Toggle dropdown visibility when the button is clicked
function toggleDropdown(button) {
    // Find the dropdown content associated with the clicked button
    const dropdownContent = button.nextElementSibling;
    
    // Toggle visibility
    if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
    } else {
        // Close all other open dropdowns
        closeAllDropdowns();
        dropdownContent.style.display = "block";
    }
}

// Close all dropdowns except the one being opened (if any)
function closeAllDropdowns() {
    const dropdowns = document.querySelectorAll(".dropdown-content");
    dropdowns.forEach(dropdown => {
        dropdown.style.display = "none";
    });
}

// Close dropdown when clicking outside
document.addEventListener("click", function(event) {
    const dropdowns = document.querySelectorAll(".dropdown");
    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector(".dropbtn");
        const content = dropdown.querySelector(".dropdown-content");
        
        // If the click is outside the dropdown button and content, close the dropdown
        if (!button.contains(event.target) && !content.contains(event.target)) {
            content.style.display = "none";
        }
    });
});

// Confirm deletion before proceeding
function confirmDelete(event) {
    event.preventDefault(); // Prevent the default link behavior
    const confirmed = confirm("Are you sure you want to delete this product?");
    if (confirmed) {
        window.location.href = event.target.closest("a").href; // Proceed to the delete URL
    }
    return false; // Prevent further action if not confirmed
}