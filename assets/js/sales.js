document.getElementById('export-button').addEventListener('click', exportToExcel);

function exportToExcel() {
    // Fetch the sales data
    const data = [
        // Example data, replace with actual sales data
        { id: 1, name: 'Sale 1', price: 100, quantity: 2, date: '2023-01-01', status: 'completed' },
        { id: 2, name: 'Sale 2', price: 200, quantity: 1, date: '2023-01-02', status: 'pending' },
    ];

    // Convert data to worksheet
    const worksheet = XLSX.utils.json_to_sheet(data);

    // Create a new workbook
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sales');

    // Export the workbook to Excel file
    XLSX.writeFile(workbook, 'sales.xlsx');
}
