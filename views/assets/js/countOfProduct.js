document.addEventListener("DOMContentLoaded", function () {
    function updateStockSummary() {
        let totalProducts = 0;
        let lowStock = 0;
        let inStock = 0;

        // Select all rows from the product table
        document.querySelectorAll("#productTable tbody tr").forEach(row => {
            totalProducts++; // Increment total product count
            let status = row.querySelector("td:nth-child(5)").textContent.trim().toLowerCase(); // Status column

            if (status === "low-stock") {
                lowStock++;
            } else {
                inStock++;
            }
        });

        // Update the stock summary section
        document.querySelector(".stock-summary h3").textContent = totalProducts; // Total Products
        document.querySelector(".col-4:nth-child(2) .card h3").textContent = lowStock; // Low Stocks
        document.querySelector(".col-4:nth-child(3) .card h3").textContent = inStock; // In Stocks
    }

    updateStockSummary(); // Run on page load
});
