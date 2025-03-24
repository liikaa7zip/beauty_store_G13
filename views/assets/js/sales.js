let salesData = [];

// Listen for input changes on product selection
document.getElementById('sale-product').addEventListener('input', function(e) {
    const input = e.target;
    const list = document.getElementById('magicHouses');
    const options = list.getElementsByTagName('option');
    
    // Find the matching option in the datalist
    for (let option of options) {
        if (option.value === input.value) {
            input.setAttribute('data-product-id', option.getAttribute('data-id'));
            input.setAttribute('data-productPrice', option.getAttribute('data-price'));
            break;
        }
    }
});

// Function to update the total price in the form and table
function updateTotalPrice() {
    let total = 0;

    // Calculate the total price by summing up the totalPrice for each sale item
    salesData.forEach(item => {
        total += item.totalPrice;
    });

    // Format the total price to 2 decimal places and update the DOM
    const totalElement = document.querySelector(".total p");
    totalElement.innerHTML = `<strong>TOTAL:</strong> $${total.toFixed(2)}`;

    // Also update the total price in the table's total row
    const totalPriceInTable = document.getElementById("total-price");
    totalPriceInTable.textContent = `$${total.toFixed(2)}`;
}

// Add sale item to the table and store it in salesData
function addSaleToTable() {
    let product = document.getElementById("sale-product").value.trim();
    let productId = document.getElementById("sale-product").getAttribute('data-product-id');
    let quantity = document.getElementById("sale-quantity").value.trim();

    // Check if product name and quantity are not empty
    if (product !== "" && quantity !== "") {
        let table = document.getElementById("sales-record-table");
        let tbody = table.querySelector("tbody");

        // Display table and buttons if hidden
        table.style.display = "table"; // Show the table
        document.getElementById("table-buttons").style.display = "block"; // Show buttons

        // Create new row for the table without the price column
        let newRow = document.createElement("tr");
        let productCell = document.createElement("td");
        let quantityCell = document.createElement("td");

        productCell.textContent = product;
        quantityCell.textContent = quantity;

        newRow.appendChild(productCell);
        newRow.appendChild(quantityCell);
        tbody.appendChild(newRow);

        // Store the sale item in salesData
        const newData = {id: productId, name: product, quantity: quantity, totalPrice: parseFloat(quantity) * parseFloat(document.getElementById('sale-product').getAttribute('data-productPrice'))};
        salesData.push(newData);

        const container = document.getElementById('sales-form');

        // Create hidden inputs for each sale item (if needed)
        salesData.forEach((item, index) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `sales[${index}]`;
            input.value = JSON.stringify({
                product_id: item.id,
                quantity: item.quantity,
                price: item.price,  // You may still need the price for other purposes
                total_price: item.totalPrice
            });
            container.appendChild(input);
        });

        // Clear the input fields
        document.getElementById("sale-product").value = "";
        document.getElementById("sale-quantity").value = "";

        // Update the total price after adding a sale item (if needed)
        updateTotalPrice();
    } else {
        // If inputs are empty, alert the user
        alert("Please enter both product name and quantity.");
    }
}


// Render the sales data in the modal's table
function renderTable() {
    const tbody = document.getElementById("order-list");
    const totalP = document.getElementById("total-price");
    let text = '';
    let total = 0;

    if (salesData.length > 0) {
        salesData.forEach((item) => {
            total += item.totalPrice;
            text += `<tr class="text-center">
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>${item.totalPrice}</td>
                    <td>$${item.totalPrice.toFixed(2)}</td>
                </tr>`;
        });
        tbody.innerHTML = text;
        totalP.textContent = `$${total.toFixed(2)}`;
    }
}

// Cancel the sales and reset the table
function cancelSales() {
    // Clear the table and hide it
    let table = document.getElementById("sales-record-table");
    let tbody = table.querySelector("tbody");
    tbody.innerHTML = "";
    table.style.display = "none";        // Hide the buttons
    document.getElementById("table-buttons").style.display = "none";
    salesData.length = 0;
}

// Submit the sales form and reset
function submitSale() {
    // Implement the logic to submit the sales data
    alert("Sales submitted successfully!");
    cancelSales();  // Reset the sales data after submission
}

// Show the modal with the sales data and initiate form submission
function submitSales() {
    // Check if there are items in the cart
    if (salesData.length === 0) {
        return; // Simply return without doing anything if no items
    }

    renderTable(); // Update modal with sales data
    document.getElementById('recipeModal').style.display = 'flex'; // Show modal

    // Delay form submission until modal is closed
    const submitBtn = document.getElementById("hidden-submit");
    submitBtn.dataset.pending = "true"; // Mark as pending submission
}

// Close the modal and submit the form after modal is closed
function closeModal() {
    document.getElementById('recipeModal').style.display = 'none'; // Hide modal

    // Now submit the form since the modal is closed
    const submitBtn = document.getElementById("hidden-submit");
    if (submitBtn.dataset.pending === "true") {
        submitBtn.dataset.pending = "false"; // Reset flag
        document.getElementById('sales-form').submit(); // Trigger the form submission
    }
}

// Show img QR
function toggleQRCode() {
    var qrImage = document.getElementById('qr-code');
    var toggleButton = document.getElementById('toggle-btn');
    
    if (qrImage.src.includes('qr-dollar.jpg')) {
        qrImage.src = '/views/assets/img/qr-khmer.jpg';
        toggleButton.innerText = 'Show Dollar QR'; // Change button text to show dollar QR
    } else {
        qrImage.src = '/views/assets/img/qr-dollar.jpg';
        toggleButton.innerText = 'Show Khmer QR'; // Change button text to show Khmer QR
    }
}