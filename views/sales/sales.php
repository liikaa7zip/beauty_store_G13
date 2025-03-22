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

                <!-- Modal Structure -->
<div id="recipeModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h1>Recipe Order</h1>
    <table>
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Price per Unit</th>
          <th>Total Price</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Sugar</td>
          <td>2 kg</td>
          <td>$3</td>
          <td>$6</td>
        </tr>
        <tr>
          <td>Flour</td>
          <td>1 kg</td>
          <td>$1.5</td>
          <td>$1.5</td>
        </tr>
        <tr>
          <td>Butter</td>
          <td>500 g</td>
          <td>$4</td>
          <td>$2</td>
        </tr>
        <tr class="total">
          <td colspan="3">Total Price</td>
          <td>$9.5</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
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

    function submitSales() {
    // Show the modal when the button is clicked
    document.getElementById('recipeModal').style.display = 'flex';
  }

  function closeModal() {
    // Close the modal
    document.getElementById('recipeModal').style.display = 'none';
  }
</script>

<style>

   /* Modal Styles */
  .modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    justify-content: center;
    align-items: center;
  }

  .modal-content {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    width: 80%;
    max-width: 600px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
  }

  .close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #f8f8f8;
    font-weight: bold;
  }

  .total {
    font-weight: bold;
    background-color: #f9f9f9;
  }

  .total td {
    text-align: right;
  }
</style>