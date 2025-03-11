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


//use for show low-stock and in-stock

document.addEventListener("DOMContentLoaded", function () {
    const stockCards = document.querySelectorAll(".card");
    const modal = document.createElement("div");

    // Create a hidden modal dynamically
    modal.id = "stockModal";
    modal.style.display = "none"; // Hide modal initially
    modal.style.position = "fixed";
    modal.style.zIndex = "1000";
    modal.style.left = "0";
    modal.style.top = "0";
    modal.style.width = "100vw";
    modal.style.height = "100vh";
    modal.style.backgroundColor = "rgba(0, 0, 0, 0.7)";
    modal.style.justifyContent = "center";
    modal.style.alignItems = "center";

    modal.innerHTML = `
        <div id="modalContent" style="
            background: white;
            padding: 25px;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            display: none; /* Hide content initially */
        ">
            <span id="closeModal" style="
                float: right;
                font-size: 26px;
                cursor: pointer;
                font-weight: bold;
                color: #ff3333;
                transition: 0.3s;
            ">&times;</span>
            <h2 id="modalTitle" style="color: #333; font-size: 24px; margin-bottom: 15px;"></h2>
            <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 16px;">
                <thead>
                    <tr style="background: linear-gradient(90deg, #2196F3, #00BCD4); color: white;">
                        <th style="border: 1px solid #ddd; padding: 12px;">Product Name</th>
                        <th style="border: 1px solid #ddd; padding: 12px;">Stocks</th>
                        <th style="border: 1px solid #ddd; padding: 12px;">Category</th>
                        <th style="border: 1px solid #ddd; padding: 12px;">Status</th>
                        <th style="border: 1px solid #ddd; padding: 12px;">Action</th>
                    </tr>
                </thead>
                <tbody id="modalTableBody"></tbody>
            </table>
            </div>
        </div>
    `;

    document.body.appendChild(modal);
    const modalTitle = document.getElementById("modalTitle");
    const modalTableBody = document.getElementById("modalTableBody");
    const closeModal = document.getElementById("closeModal");
    const modalContent = document.getElementById("modalContent");

    stockCards.forEach(card => {
        card.addEventListener("click", function () {
            const title = this.querySelector("p").innerText;

            if (title === "Low-stocks" || title === "In-stocks") {
                modalTitle.innerText = title + " List";
                modalTableBody.innerHTML = ""; // Clear previous data

                document.querySelectorAll("#stocks tbody tr").forEach(row => {
                    const productName = row.querySelector("td:first-child").innerText.trim();
                    const stocks = row.querySelector("td:nth-child(2)").innerText.trim();
                    const category = row.querySelector("td:nth-child(3)").innerText.trim();
                    const status = row.querySelector("td:nth-child(4)").innerText.trim();
                    const action = row.querySelector("td:nth-child(5)").innerHTML;

                    if ((title === "Low-stocks" && status.toLowerCase() === "low-stock") ||
                        (title === "In-stocks" && status.toLowerCase() === "instock")) {


                            const rowHTML = `<tr style="border-bottom: 1px solid #ddd; background: ${status.toLowerCase() === 'low-stock' ? '#FFEBEE' : '#E8F5E9'};">
                            <td style="padding: 12px; border: 1px solid #ddd; font-weight: bold;">${productName}</td>
                            <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">${stocks}</td>
                            <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">${category}</td>
                            <td style="padding: 12px; border: 1px solid #ddd; text-align: center; font-weight: bold; color: ${status.toLowerCase() === 'low-stock' ? 'red' : 'green'};">
                                ${status}
                            </td>
                            <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">${action}</td>
                         </tr>`;
        modalTableBody.innerHTML += rowHTML;
    }
});

if (modalTableBody.innerHTML.trim() !== "") {
    modal.style.display = "flex";  // Show modal background
    modalContent.style.display = "block"; // Show modal content
}
}
});
});

closeModal.addEventListener("click", function () {
modal.style.display = "none";
modalContent.style.display = "none";
});

window.addEventListener("click", function (event) {
if (event.target === modal) {
modal.style.display = "none";
modalContent.style.display = "none";
}
});
});

