document.getElementById('searchProducts').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#stocks tbody tr');

    rows.forEach(function(row) {
        const productName = row.cells[0].textContent.toLowerCase(); // Product name column
        if (productName.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
