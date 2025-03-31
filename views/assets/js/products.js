// function triggerImport() {
//     const fileInput = document.createElement('input');
//     fileInput.type = 'file';
//     fileInput.accept = '.xlsx, .csv';
//     fileInput.style.display = 'none';
//     document.body.appendChild(fileInput);

//     fileInput.click();

//     fileInput.onchange = function(e) {
//         const file = e.target.files[0];
//         if (!file) {
//             document.body.removeChild(fileInput);
//             return;
//         }

//         const toast = new bootstrap.Toast(document.getElementById('notification'));
//         document.getElementById('fileName').textContent = file.name;
//         document.getElementById('fileSize').textContent = `${(file.size / 1024).toFixed(2)} KB`;
//         document.getElementById('status').textContent = 'Validating...';
//         toast.show();

//         const reader = new FileReader();
//         reader.onload = function(event) {
//             try {
//                 const data = new Uint8Array(event.target.result);
//                 const workbook = XLSX.read(data, { type: 'array' });

//                 // Check the first sheet
//                 const firstSheetName = workbook.SheetNames[0];
//                 const worksheet = workbook.Sheets[firstSheetName];

//                 // Expected column headers (excluding Actions)
//                 const expectedHeaders = ['Name', 'Stock', 'Category', 'Status'];
//                 const headers = XLSX.utils.sheet_to_json(worksheet, { header: 1 })[0] || [];

//                 // Validate headers
//                 const missingHeaders = expectedHeaders.filter(header => !headers.includes(header));
//                 if (missingHeaders.length > 0) {
//                     document.getElementById('status').textContent = `Error: Missing headers: ${missingHeaders.join(', ')}`;
//                     document.body.removeChild(fileInput);
//                     return;
//                 }

//                 // Check if there’s data beyond headers
//                 const jsonData = XLSX.utils.sheet_to_json(worksheet);
//                 if (jsonData.length <= 0) { // No data rows (excluding header)
//                     document.getElementById('status').textContent = 'Error: No data rows found';
//                     document.body.removeChild(fileInput);
//                     return;
//                 }

//                 // If validation passes, proceed with upload
//                 document.getElementById('status').textContent = 'Processing...';
//                 const formData = new FormData();
//                 formData.append('file', file);

//                 fetch('/inventory/import/import', {
//                     method: 'POST',
//                     body: formData
//                 })
//                 .then(response => {
//                     if (!response.ok) {
//                         throw new Error(`HTTP error! Status: ${response.status}`);
//                     }
//                     return response.json();
//                 })
//                 .then(data => {
//                     if (data.success) {
//                         document.getElementById('status').textContent = 'Done';
//                         console.log('Import successful:', data.message);
//                         location.reload(); // Reload to refresh table with new data
//                     } else {
//                         document.getElementById('status').textContent = 'Error: ' + data.message;
//                         console.error('Import failed:', data.message);
//                     }
//                 })
//                 .catch(error => {
//                     document.getElementById('status').textContent = 'Error: Import failed - ' + error.message;
//                     console.error('Fetch error:', error);
//                 });
//             } catch (error) {
//                 document.getElementById('status').textContent = 'Error: Invalid file format - ' + error.message;
//                 console.error('File reading error:', error);
//             }
//             document.body.removeChild(fileInput);
//         };reader.onerror = function() {
//             document.getElementById('status').textContent = 'Error: Failed to read file';
//             document.body.removeChild(fileInput);
//         };

//         reader.readAsArrayBuffer(file);
//     };
// }






// EXPORT TO EXCEL
function exportToExcel() {
    try {
        console.log('Export button clicked');
        const table = document.getElementById("productTable");
        let wb;

        if (table) {
            const rows = table.getElementsByTagName('tr');
            const data = [];

            // Process header row
            const headerRow = Array.from(rows[0].getElementsByTagName('th'))
                .map(th => th.textContent)
                .filter((_, index) => index < 6); // Exclude Actions column
            data.push(headerRow);

            // Process data rows
            for (let i = 1; i < rows.length; i++) {
                const cells = Array.from(rows[i].getElementsByTagName('td'))
                    .map(td => td.textContent)
                    .filter((_, index) => index < 6);
                data.push(cells);
            }

            const ws = XLSX.utils.aoa_to_sheet(data);
            wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

            if (rows.length <= 1) {
                alert('No data in the table! Exporting empty template.');
                const minimalData = [["Name", "Price", "Stock", "Category", "Status"]];
                const minimalWs = XLSX.utils.aoa_to_sheet(minimalData);
                wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, minimalWs, "Sheet1");
            }
            console.log('Table data exported to Excel');
        } else {
            const minimalData = [["Name", "Price", "Stock", "Category", "Status"]];
            const ws = XLSX.utils.aoa_to_sheet(minimalData);
            wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            console.warn('No table found. Exported empty template.');
        }

        XLSX.writeFile(wb, "products_export.xlsx");
        console.log('Export to Excel completed');
    } catch (e) {
        console.error("Export failed:", e);
        alert("Error exporting to Excel.");
    }
}

// IMPORT EXCEL FILE
// function triggerImport() {
//     const fileInput = document.createElement('input');
//     fileInput.type = 'file';
//     fileInput.accept = '.xlsx, .csv';
//     fileInput.style.display = 'none';
//     document.body.appendChild(fileInput);
//     fileInput.click();

//     fileInput.onchange = function (e) {
//         const file = e.target.files[0];
//         if (!file) {
//             document.body.removeChild(fileInput);
//             return;
//         }

//         const toast = new bootstrap.Toast(document.getElementById('notification'));
//         document.getElementById('fileName').textContent = file.name;
//         document.getElementById('fileSize').textContent = `${(file.size / 1024).toFixed(2)} KB`;
//         document.getElementById('status').textContent = 'Validating...';
//         toast.show();

//         const reader = new FileReader();
//         reader.onload = function (event) {
//             try {
//                 const data = new Uint8Array(event.target.result);
//                 const workbook = XLSX.read(data, { type: 'array' });

//                 const firstSheetName = workbook.SheetNames[0];
//                 const worksheet = workbook.Sheets[firstSheetName];

//                 const expectedHeaders = ['Name', 'Price', 'Stock', 'Category', 'Status'];
//                 const headers = XLSX.utils.sheet_to_json(worksheet, { header: 1 })[0] || [];

//                 const missingHeaders = expectedHeaders.filter(header => !headers.includes(header));
//                 if (missingHeaders.length > 0) {
//                     document.getElementById('status').textContent = `Error: Missing headers: ${missingHeaders.join(', ')}`;
//                     document.body.removeChild(fileInput);
//                     return;
//                 }

//                 const jsonData = XLSX.utils.sheet_to_json(worksheet);
//                 if (jsonData.length <= 0) {
//                     document.getElementById('status').textContent = 'Error: No data rows found';
//                     document.body.removeChild(fileInput);
//                     return;
//                 }

//                 document.getElementById('status').textContent = 'Processing...';
//                 updateTable(jsonData, expectedHeaders);
//             } catch (error) {
//                 document.getElementById('status').textContent = 'Error: Invalid file format';
//                 console.error('File reading error:', error);
//             }
//             document.body.removeChild(fileInput);
//         };

//         reader.onerror = function () {
//             document.getElementById('status').textContent = 'Error: Failed to read file';
//             document.body.removeChild(fileInput);
//         };

//         reader.readAsArrayBuffer(file);
//     };
// }


function triggerImport() {
    console.log('Import button clicked'); // Confirms button click
    
    // Create file input element
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = '.xlsx, .xls, .csv';
    fileInput.style.display = 'none';
    
    // Add to DOM and trigger click
    document.body.appendChild(fileInput);
    fileInput.click();
    
    // Handle file selection
    fileInput.addEventListener('change', async (event) => {
        const file = event.target.files[0];
        if (!file) {
            document.body.removeChild(fileInput);
            return;
        }

        console.log('Selected file:', file.name);
        
        try {
            // Read Excel file
            const rows = await readXlsxFile(file);
            console.log('File contents:', rows);
            
            // Process and display data
            displayExcelData(rows);
            
            // Show success message
            showImportStatus('File imported successfully!', 'success');
        } catch (error) {
            console.error('Import failed:', error);
            showImportStatus('Import failed: ' + error.message, 'error');
        } finally {
            document.body.removeChild(fileInput);
        }
    });
}

function displayExcelData(rows) {
    const table = document.getElementById('excel-table');
    if (!table) {
        document.body.insertAdjacentHTML(
            'beforeend',
            '<p style="color:red;">❌ Error: Table not found! Please add a table with ID "excel-table".</p>'
        );
        return;
    }
    

    // Clear existing data
    table.innerHTML = '';
    
    // Create header row if data exists
    if (rows.length > 0) {
        const headerRow = document.createElement('tr');
        rows[0].forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        table.appendChild(headerRow);
    }
    
    // Create data rows (skip header if exists)
    const startRow = rows.length > 1 ? 1 : 0;
    for (let i = startRow; i < rows.length; i++) {
        const tr = document.createElement('tr');
        rows[i].forEach(cell => {
            const td = document.createElement('td');
            td.textContent = cell !== null ? cell : '';
            tr.appendChild(td);
        });
        table.appendChild(tr);
    }
}

function showImportStatus(message, type) {
    const statusElement = document.getElementById('import-status') || createStatusElement();
    statusElement.textContent = message;
    statusElement.className = `import-status ${type}`;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        statusElement.textContent = '';
        statusElement.className = 'import-status';
    }, 5000);
}

function createStatusElement() {
    const statusElement = document.createElement('div');
    statusElement.id = 'import-status';
    statusElement.className = 'import-status';
    document.querySelector('.import-btn').insertAdjacentElement('afterend', statusElement);
    return statusElement;
}

// UPDATE TABLE & ALERT MISSING IMAGES
function updateTable(dataRows, headers) {
    const tableBody = document.querySelector("#productTable tbody");

    dataRows.forEach(row => {
        const rowData = {};
        headers.forEach((header, index) => {
            rowData[header] = row[header] || ''; // Handle missing values
        });

        let existingRow = [...tableBody.rows].find(r => r.cells[1].textContent.trim() === rowData['Name']);

        if (existingRow) {
            existingRow.cells[2].textContent = rowData['Price'];
            existingRow.cells[3].textContent = rowData['Stock'];
            existingRow.cells[4].textContent = rowData['Category'];
            existingRow.cells[5].textContent = rowData['Status'];
        } else {
            let imageUrl = prompt(`Please provide an image URL for "${rowData['Name']}":`);
            if (!imageUrl) {
                alert(`Cannot add "${rowData['Name']}" without an image.`);
                return;
            }

            const newRow = tableBody.insertRow();
            newRow.innerHTML = `
                <td><img src="${imageUrl}" alt="Product Image" width="50" height="50"></td>
                <td>${rowData['Name']}</td>
                <td>${rowData['Price']}</td>
                <td>${rowData['Stock']}</td>
                <td>${rowData['Category']}</td>
                <td>${rowData['Status']}</td>
                <td><button class="btn btn-sm btn-danger" onclick="deleteRow(this)">Delete</button></td>
            `;
        }
    });

    console.log('Table updated with new data');
}


// DELETE ROW FUNCTION
function deleteRow(button) {
    button.closest("tr").remove();
    console.log('Row deleted');
}






/*export*/
// function exportToExcel() {
//     try {
//         console.log('Export button clicked');

//         // Try to get the table element by its ID
//         const table = document.getElementById("productTable");

//         let wb;

//         if (table) {
//             // If the table exists, convert table to worksheet and exclude Actions column
//             const rows = table.getElementsByTagName('tr');
//             const data = [];

//             // Process header row, excluding Actions
//             const headerRow = Array.from(rows[0].getElementsByTagName('th'))
//                 .map(th => th.textContent)
//                 .filter((header, index) => index < 4); // Exclude the last column (Actions)
//             data.push(headerRow);

//             // Process data rows, excluding Actions
//             for (let i = 1; i < rows.length; i++) {
//                 const cells = Array.from(rows[i].getElementsByTagName('td'))
//                     .map(td => td.textContent)
//                     .filter((cell, index) => index < 4); // Exclude the last column (Actions)
//                 data.push(cells);
//             }

//             // Create worksheet from processed data
//             const ws = XLSX.utils.aoa_to_sheet(data);
//             wb = XLSX.utils.book_new();
//             XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

//             // Check if the table has data beyond the header
//             if (rows.length <= 1) {
//                 alert('No data in the table! Exporting empty template.');
//                 const minimalData = [["Name", "Stock", "Category", "Status"]];
//                 const minimalWs = XLSX.utils.aoa_to_sheet(minimalData);
//                 wb = XLSX.utils.book_new();
//                 XLSX.utils.book_append_sheet(wb, minimalWs, "Sheet1");
//             }
//             console.log('Table data exported to Excel (Actions excluded)');
//         } else {
//             // If the table doesn't exist, export a minimal template without Actions
//             const minimalData = [["Name", "Stock", "Category", "Status"]];
//             const ws = XLSX.utils.aoa_to_sheet(minimalData);
//             wb = XLSX.utils.book_new();
//             XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
//             console.warn('No table found. Exported empty template.');
//         }

//         // Generate Excel file and trigger download
//         XLSX.writeFile(wb, "products_export.xlsx");
//         console.log('Export to Excel completed');
//     } catch (e) {
//         console.error("Export failed:", e);
//         alert("Error exporting to Excel. Check console for details.");
//     }
// }



function exportToExcel() {
    try {
        console.log('Export button clicked');

        const table = document.getElementById("productTable");
        let wb;

        if (table) {
            const rows = table.getElementsByTagName('tr');
            const data = [];

            if (rows.length === 0) {
                throw new Error("Table has no data!");
            }

            // Extract headers dynamically & clean up text
            const headerCells = Array.from(rows[0].getElementsByTagName('th'));
            const headers = headerCells.map(th => th.textContent.trim().toLowerCase());

            console.log('Extracted Headers:', headers);

            // Expected headers: Ensure we are extracting correct columns
            const expectedHeaders = ['name', 'price', 'stock', 'category']; 
            const indices = expectedHeaders.map(h => headers.indexOf(h));

            if (indices.includes(-1)) {
                throw new Error("One or more expected headers are missing!");
            }

            // Push header row (case-corrected)
            data.push(expectedHeaders.map(h => h.charAt(0).toUpperCase() + h.slice(1)));

            // Process table rows
            for (let i = 1; i < rows.length; i++) {
                const cells = Array.from(rows[i].getElementsByTagName('td'));
                const rowData = indices.map(index => index !== -1 ? cells[index].textContent.trim() : "");
                
                if (rowData[0]) {  // Ensure "Name" is not empty
                    data.push(rowData);
                }
            }

            // If no valid rows, export only the headers
            if (data.length <= 1) {
                alert('No valid product data. Exporting empty template.');
                data.push(["", "", "", ""]); 
            }

            const ws = XLSX.utils.aoa_to_sheet(data);
            wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

        } else {
            throw new Error("Table element not found!");
        }

        // Generate Excel file
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
// document.addEventListener("click", function(event) {
//     const dropdowns = document.querySelectorAll(".dropdown");
//     dropdowns.forEach(dropdown => {
//         const button = dropdown.querySelector(".dropbtn");
//         const content = dropdown.querySelector(".dropdown-content");
        
//         // If the click is outside the dropdown button and content, close the dropdown
//         if (!button.contains(event.target) && !content.contains(event.target)) {
//             content.style.display = "none";
//         }
//     });
// });

function addRowToTable(product) {
    const tableBody = document.querySelector("table tbody"); // Find table body
    if (!tableBody) {
        console.error("Table body not found");
        return;
    }

    const row = document.createElement("tr");

    row.innerHTML = `
        <td><img src="${product.image}" alt="Product" style="width:50px; height:50px; border-radius:50%;"></td>
        <td>${product.name}</td>
        <td>${product.price}</td>
        <td>${product.stock}</td>
        <td>${product.category}</td>
        <td style="color:${product.stock <= 5 ? 'red' : 'black'}">${product.stock <= 5 ? 'Low-stock' : 'In-stock'}</td>
        <td>
            <button class="action-btn">...</button>
        </td>
    `;

    tableBody.appendChild(row);
}

// Example Usage
// const newProduct = {
//     image: "https://via.placeholder.com/50", // Replace with actual product image
//     name: "New Product",
//     price: "$15.00",
//     stock: 3,
//     category: "Shirts"
// };

// addRowToTable(newProduct);






// Confirm deletion before proceeding
function confirmDelete(event) {
    event.preventDefault(); // Prevent the default link behavior
    const confirmed = confirm("Are you sure you want to delete this product?");
    if (confirmed) {
        window.location.href = event.target.closest("a").href; // Proceed to the delete URL
    }
    return false; // Prevent further action if not confirmed
}

// Show success modal when category is added
document.querySelector(".category-container").addEventListener("submit", function(event) {
    event.preventDefault(); // Stop form submission
    document.getElementById("uniqueSuccessModal").style.display = "block"; // Show modal
});

document.getElementById("uniqueCloseModal").addEventListener("click", function() {
    document.getElementById("uniqueSuccessModal").style.display = "none"; // Hide modal
    document.querySelector(".category-container").submit(); // Now submit the form
});