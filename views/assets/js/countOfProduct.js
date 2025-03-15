document.addEventListener("DOMContentLoaded", function () {
    function updateStockSummary() {
        let totalProducts = 0;
        let lowStock = 0;
        let inStock = 0;
        
        document.querySelectorAll("#productTable tbody tr").forEach(row => {
            totalProducts++;
            let status = row.querySelector("td:nth-child(4)").textContent.trim().toLowerCase();
            
            if (status === "low-stock") {
                lowStock++;
            } else {
                inStock++;
            }
        });
        
        document.querySelector(".stock-summary .card:nth-child(1) h3").textContent = totalProducts;
        document.querySelector(".stock-summary .card:nth-child(2) h3").textContent = lowStock;
        document.querySelector(".stock-summary .card:nth-child(3) h3").textContent = inStock;
    }
    
    updateStockSummary(); // Run on page load
    
    // Button to manually update count
    let countButton = document.createElement("button");
    countButton.textContent = "Update Stock Count";
    countButton.classList.add("update-button");
    countButton.onclick = updateStockSummary;
    
    document.querySelector(".stocks-container").appendChild(countButton);
});
