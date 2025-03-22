<div class="sales-wrapper">
    <!-- Left: Sales Form -->
    <div class="sales-form">
        <h1 class="sales-header">Sales Management</h1>
        <div class="sales-container">
            <div class="input-group">
                <input type="text" id="sale-product" class="input-field" placeholder="Product Name">
                <input type="number" id="sale-quantity" class="input-field" placeholder="Quantity">
            </div>
            <div class="button-container">
                <button onclick="addSaleToTable()" class="ok-button">OK</button>
            </div>
            <!-- Table under inputs -->
            <table id="sales-record-table" class="sales-table" style="display: none;">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th id="quantity">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="table-buttons" class="table-button-container" style="display: none;">
                <button onclick="cancelSales()" class="cancel-button" style="border:none;">Cancel</button>
                <button onclick="submitSales()" class="submit-button" style="border:none;">Submit</button>
            </div>
        </div>
    </div>

    <!-- Right: Image -->
    <div class="sales-image">
        <img src="/views/assets/img/qr.jpg" alt="Sales Image">
    </div>
</div>

<script>
    function addSaleToTable() {
        let product = document.getElementById("sale-product").value.trim();
        let quantity = document.getElementById("sale-quantity").value.trim();

        // Check if product name and quantity are not empty
        if (product !== "" && quantity !== "") {
            let table = document.getElementById("sales-record-table");
            let tbody = table.querySelector("tbody");

            // Display table and buttons if hidden
            table.style.display = "table"; // Show the table
            document.getElementById("table-buttons").style.display = "block"; // Show buttons

            // Create new row and append to tbody
            let newRow = document.createElement("tr");
            let productCell = document.createElement("td");
            let quantityCell = document.createElement("td");

            productCell.textContent = product;
            quantityCell.textContent = quantity;

            newRow.appendChild(productCell);
            newRow.appendChild(quantityCell);
            tbody.appendChild(newRow);

            // Clear the input fields
            document.getElementById("sale-product").value = "";
            document.getElementById("sale-quantity").value = "";
        } else {
            // If inputs are empty, alert the user
            alert("Please enter both product name and quantity.");
        }
    }

    function cancelSales() {
        // Clear the table and hide it
        let table = document.getElementById("sales-record-table");
        let tbody = table.querySelector("tbody");
        tbody.innerHTML = "";
        table.style.display = "none";

        // Hide the buttons
        document.getElementById("table-buttons").style.display = "none";
    }

    function submitSales() {
        // Implement the logic to submit the sales data
        alert("Sales submitted successfully!");
        cancelSales();
    }
</script>