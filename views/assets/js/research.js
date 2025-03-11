// Research 

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



// Count products list 

document.addEventListener("DOMContentLoaded", function () {
    function updateStockSummary() {
        let totalProducts = 0;
        let lowStockCount = 0;
        let inStockCount = 0;

        const stockRows = document.querySelectorAll("#stocks tbody tr");
        stockRows.forEach(row => {
            totalProducts++;
            const statusCell = row.querySelector("td:nth-child(4)");
            if (statusCell) {
                const status = statusCell.textContent.trim().toLowerCase();
                if (status === "low-stock") {
                    lowStockCount++;
                } else if (status === "instock") {
                    inStockCount++;
                }
            }
        });

        // Displaying the correct counts in the stock summary
        const cards = document.querySelectorAll(".stock-summary .card h3");
        if (cards.length >= 3) {
            cards[0].textContent = totalProducts;
            cards[1].textContent = lowStockCount;
            cards[2].textContent = inStockCount;
        }
    }

    updateStockSummary();
});
