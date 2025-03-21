<h1 class="sales-header">Sales Management</h1>
<div class="sales-container">
    <div class="input-group">
        <input type="text" id="sale-product" class="input-field" placeholder="Product Name">
        <input type="number" id="sale-quantity" class="input-field" placeholder="Quantity">
    </div>
    <div class="button-container">
        <button onclick="addSaleToTable()" class="ok-button">OK</button>
    </div>
    <table id="sales-record-table" class="sales-table">
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
        <button onclick="cancelSales()" class="cancel-button">Cancel</button>
        <button onclick="submitSales()" class="submit-button">Submit</button>
    </div>
</div>

<script>
    function addSaleToTable() {
        let product = document.getElementById("sale-product").value;
        let quantity = document.getElementById("sale-quantity").value;
        if (product && quantity) {
            let table = document.getElementById("sales-record-table");
            let buttonContainer = document.getElementById("table-buttons");
            table.style.display = "table";
            buttonContainer.style.display = "block";
            
            let tbody = table.getElementsByTagName('tbody')[0];
            let newRow = tbody.insertRow();
            newRow.insertCell(0).innerText = product;
            newRow.insertCell(1).innerText = quantity;
            
            document.getElementById("sale-product").value = "";
            document.getElementById("sale-quantity").value = "";
        }
    }

    function cancelSales() {
        let tbody = document.getElementById("sales-record-table").getElementsByTagName('tbody')[0];
        tbody.innerHTML = "";
        document.getElementById("table-buttons").style.display = "none";
    }

    function submitSales() {
        // Add your submit logic here
        alert("Sales submitted!");
        let tbody = document.getElementById("sales-record-table").getElementsByTagName('tbody')[0];
        tbody.innerHTML = "";
        document.getElementById("table-buttons").style.display = "none";
    }
</script>