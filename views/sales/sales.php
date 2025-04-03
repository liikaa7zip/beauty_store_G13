<div class="sales-wrapper">
    <!-- Left: Sales Form -->
    <div class="sales-form">
        <h1 class="sales-header">Sales Management</h1>
        <div class="sales-container">
          <div class="input-group">
            <input type="text" list="magicHouses" id="sale-product" class="input-field" placeholder="Product Name" data-product-id="">
            <datalist id="magicHouses">
                <?php foreach($products as $prod):?>
                  <option value="<?= htmlspecialchars($prod['name']) ?>" 
                     data-id="<?= $prod['id'] ?>" 
                     data-price="<?= $prod['price'] ?>"
                     data-stock="<?= $prod['stocks'] ?>">  <!-- Add stock here -->
                <?php endforeach;?>
            </datalist>
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
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

            <div id="table-buttons" class="table-button-container" style="display: none;">
                <form id="sales-form" method="post" action="/sales/create">
                  <input type="hidden" name="sales[]">
                  <button type="submit" id="hidden-submit" style="display:none">Submit</button>
                </form>
                <button onclick="cancelSales()" class="cancel-button" style="border:none">Cancel</button>
                <button onclick="submitSales()" class="submit-button" style="border:none">Submit</button>

                <!-- Modal Structure -->
    <div id="recipeModal" class="modal">
        <div id="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <header>
                <h1>Beauty Store</h1>
                <p id="recipe">Address: BP 511 St. 371 Phum Tropeang Chhuk (Borey Sorla) Sangkat, Tek Thla Khan Sen Sok, Phnom Penh, CAMBODIA</p>
            </header>
            <h2 id="h2-recipe">Invoice</h2>
            <div class="invoice-details">
                <p><strong>Date:</strong> <?= date('Y-m-d') ?></p>
                <p><strong>Time:</strong> <?= date('h:i A') ?></p>
            </div>
            <table id="invoice-table"> <!-- Unique ID for invoice table -->
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price per Unit</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="order-list">
                    <!-- Dynamic rows will be added here -->
                </tbody>
            </table>
            <div class="total">
                <p><strong>TOTAL:</strong> $<span id="total-amount">0.00</span></p> <!-- Total amount in div -->
            </div>
            <!-- Button to Download PDF -->
    <button class="btn-pdf" onclick="exportToPDF()">Download PDF</button>
        </div>
    </div>

            </div>
        </div>
    </div>

    <div class="sales-image" style="text-align: center;">
      <img id="qr-code" src="/views/assets/img/qr-dollar.jpg" alt="Sales QR Code">
      <!-- Button placed under the image -->
      <button id="toggle-btn" onclick="toggleQRCode()">Show Khmer QR</button>
    </div>


<div id="stockModal" class="custom-modal">
     <div id="modalContent" class="modal-content">
         <h2 id="modalMessage" class="modal-message"></h2>
         <button id="closeModalBtn" class="modal-close-btn">Close</button>
     </div>
 </div>
 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
 <script>
       function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Set up fonts and sizes
    doc.setFont("helvetica", "normal");
    doc.setFontSize(16);

    // Title (Beauty Store Invoice)
    doc.setTextColor(0, 0, 0); // Black color
    doc.text("Beauty Store", 20, 20);

    // Address
    doc.setFontSize(10);
    doc.text("Address: BP 511 St. 371 Phum Tropeang Chhuk, Phnom Penh, CAMBODIA", 20, 30);

    // Date and Time
    doc.setFontSize(12);
    doc.text("Date: 11/4/25", 20, 40);
    doc.text("Time: 8:10 AM", 20, 50);

    // Draw Table Header
    const headers = ["Product Name", "Quantity", "Price per Unit", "Total Price"];
    let x = 20;
    let y = 60;
    const cellHeight = 10;
    const cellWidth = [70, 30, 40, 40]; // Adjusting width of each column

    // Header
    doc.setFont("helvetica", "bold");
    for (let i = 0; i < headers.length; i++) {
        doc.text(headers[i], x + i * cellWidth[i], y);
    }

    // Draw a line under the header
    y += cellHeight;
    doc.line(x, y, x + cellWidth[0] + cellWidth[1] + cellWidth[2] + cellWidth[3], y);

    // Table Content
    doc.setFont("helvetica", "normal");
    const data = [
        ["Example Product", "2", "$5.00", "$10.00"]
    ];
    for (let i = 0; i < data.length; i++) {
        y += cellHeight;
        for (let j = 0; j < data[i].length; j++) {
            doc.text(data[i][j], x + j * cellWidth[j], y);
        }
    }

    // Total Amount
    y += cellHeight + 5;
    doc.setFont("helvetica", "bold");
    doc.text("TOTAL: $10.00", x, y);

    // Save the PDF
    doc.save("invoice.pdf");
}

function addSaleToTable() {
    const productInput = document.getElementById("sale-product");
    const quantityInput = document.getElementById("sale-quantity");
    const table = document.getElementById("sales-record-table").querySelector("tbody");

    const productName = productInput.value;
    const quantity = quantityInput.value;

    if (productName && quantity > 0) {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${productName}</td>
            <td>
                <button class="quantity-btn" onclick="decrementQuantity(this)">-</button>
                <input type="number" class="quantity-input" value="${quantity}" min="1" onchange="updateQuantity(this)">
                <button class="quantity-btn" onclick="incrementQuantity(this)">+</button>
            </td>
        `;

        table.appendChild(row);
        document.getElementById("sales-record-table").style.display = "table";
        document.getElementById("table-buttons").style.display = "block";

        // Clear inputs
        productInput.value = "";
        quantityInput.value = "";
    } else {
        alert("Please enter a valid product and quantity.");
    }
}

function updateQuantity(input) {
    const newQuantity = input.value;
    if (newQuantity < 1) {
        alert("Quantity must be at least 1.");
        input.value = 1;
    }
    console.log(`Updated quantity: ${newQuantity}`);
}

function incrementQuantity(button) {
    const input = button.previousElementSibling;
    input.value = parseInt(input.value) + 1;
    updateQuantity(input);
}

function decrementQuantity(button) {
    const input = button.nextElementSibling;
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        updateQuantity(input);
    } else {
        alert("Quantity must be at least 1.");
    }
}
</script>

<style>
        .btn-pdf {
            padding: 10px 15px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-pdf:hover {
            background-color: #218838;
        }

        .close-btn {
            float: right;
            cursor: pointer;
            font-size: 20px;
        }

        .quantity-btn {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin: 0 5px;
        }
        .quantity-btn:hover {
            background-color: #0056b3;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
        }
        .quantity-input:focus {
            outline: none;
            border-color: #007bff;
        }

        .sales-wrapper {
            overflow: hidden; /* Disable scrolling for this section */
        }

        /* Hide scrollbar for modern browsers */
        .sales-wrapper::-webkit-scrollbar {
            display: none;
        }
        .sales-wrapper {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
    </style>
