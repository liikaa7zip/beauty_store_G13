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
            console.log("No file selected.");
            document.body.removeChild(fileInput);
            return;
        }

        // Display file info
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = `${(file.size / 1024).toFixed(2)} KB`;
        document.getElementById('status').textContent = 'Validating...';
        const toast = new bootstrap.Toast(document.getElementById('notification'));
        toast.show();

        const reader = new FileReader();
        reader.onload = function(event) {
            try {
                const data = new Uint8Array(event.target.result);
                const workbook = XLSX.read(data, { type: 'array' });

                // Debugging: Log workbook content
                console.log("Workbook Loaded:", workbook);

                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];

                // Expected column headers
                const expectedHeaders = ['Name', 'Stock', 'Category', 'Status'];
                const headers = XLSX.utils.sheet_to_json(worksheet, { header: 1 })[0] || [];

                // Debugging: Log file headers
                console.log("Extracted Headers:", headers);

                // Validate headers
                const missingHeaders = expectedHeaders.filter(header => !headers.includes(header));
                if (missingHeaders.length > 0) {
                    document.getElementById('status').textContent = `Error: Missing headers: ${missingHeaders.join(', ')}`;
                    console.error("Header validation failed:", missingHeaders);
                    document.body.removeChild(fileInput);
                    return;
                }

                // Check if file contains data beyond headers
                const jsonData = XLSX.utils.sheet_to_json(worksheet);
                if (jsonData.length === 0) {
                    document.getElementById('status').textContent = 'Error: No data rows found';
                    console.error("File contains no data rows.");
                    document.body.removeChild(fileInput);
                    return;
                }

                // Proceed with file upload
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
                    console.log("Server Response:", data);
                    if (data.success) {
                        document.getElementById('status').textContent = 'Done';
                        console.log('Import successful:', data.message);
                        location.reload();
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
            } finally {
                document.body.removeChild(fileInput);
            }
        };

        reader.onerror = function() {
            document.getElementById('status').textContent = 'Error: Failed to read file';
            console.error('FileReader error');
            document.body.removeChild(fileInput);
        };

        reader.readAsArrayBuffer(file);
    };
}