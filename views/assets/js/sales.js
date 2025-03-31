let salesData = [];
document.getElementById('sale-product').addEventListener('input', function(e) {
    const input = e.target;
    const list = document.getElementById('magicHouses');
    const options = list.getElementsByTagName('option');
    for (let option of options) {
        if (option.value === input.value) {
            input.setAttribute('data-product-id', option.getAttribute('data-id'));
            input.setAttribute('data-productPrice', option.getAttribute('data-price'));
            input.setAttribute('data-stock', option.getAttribute('data-stock')); // Get stock
            break;
        }
    }
});

    // Function to update the total price in the form and table
    function updateTotalPrice() {
        let total = 0;
    
        // Calculate the total price
        salesData.forEach(item => {
            total += Number(item.totalPrice);
        });
    
        // Update only the total amount in the div
        const totalAmountSpan = document.getElementById("total-amount");
        if (totalAmountSpan) {
            totalAmountSpan.textContent = total.toFixed(2);
        } else {
            console.error("Element with id 'total-amount' not found!");
        }
    }
    


function addSaleToTable() {
    let productInput = document.getElementById("sale-product");
    let product = productInput.value.trim();
    let productId = productInput.getAttribute('data-product-id');
    let productPrice = productInput.getAttribute('data-productPrice');
    let productStock = productInput.getAttribute('data-stock'); // Get stock value
    let quantity = document.getElementById("sale-quantity").value.trim();

    // Convert stock and quantity to numbers
    let stock = parseInt(productStock, 10);
    let quantityNum = parseInt(quantity, 10);

    // Check if product name and quantity are not empty
    if (product === "" || quantity === "") {
        alert("Please enter both product name and quantity.");
        return;
    }

   // Check if entered quantity is greater than stock
if (quantityNum > stock) {
    var modal = document.getElementById('stockModal');
    var modalMessage = document.getElementById('modalMessage');
    var closeModalBtn = document.getElementById('closeModalBtn');

    modalMessage.textContent = "Stock not enough! Available stock: " + stock;

    // Show the modal with smooth animation
    modal.style.display = 'flex';

    // Close the modal when the close button is clicked
    closeModalBtn.onclick = function() {
        modal.style.display = 'none';
    };

    return; // Stop execution
}



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

    const newData = {
        id: productId,
        name: product,
        quantity: quantityNum,
        price: productPrice,
        totalPrice: productPrice * quantityNum
    };
    salesData.push(newData);

    // Create hidden inputs for each sale item
    const container = document.getElementById('sales-form');
    salesData.forEach((item, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `sales[${index}]`;
        input.value = JSON.stringify({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price,
            total_price: item.totalPrice
        });
        container.appendChild(input);
    });

    // Clear the input fields
    document.getElementById("sale-product").value = "";
    document.getElementById("sale-quantity").value = "";
    console.log(salesData);
}


function renderTable() {
    const tbody = document.getElementById("order-list"); // Table body
    const totalAmount = document.getElementById("total-amount"); // Total in div
    let text = "";
    let total = 0;

    // Loop through salesData to generate table rows
    salesData.forEach((item) => {
        total += item.totalPrice;
        text += `<tr class="text-center">
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                    <td>$${item.totalPrice.toFixed(2)}</td>
                 </tr>`;
    });

    tbody.innerHTML = text; // Fill the table with product rows

    // Update the total in the <div> (not in the table)
    if (totalAmount) {
        totalAmount.textContent = total.toFixed(2);
    }
}


    function cancelSales() {
        // Clear the table and hide it
        let table = document.getElementById("sales-record-table");
        let tbody = table.querySelector("tbody");
        tbody.innerHTML = "";
        table.style.display = "none";  // Hide the buttons
        document.getElementById("table-buttons").style.display = "none";
        salesData.length=0
        console.log(salesData);
        
    }

    // function prepareHiddenInputs() {
    //     const container = document.getElementById('sales-form');
    //     container.innerHTML = ""; 
    
    //     salesData.forEach((item, index) => {
    //         let input = document.createElement('input');
    //         input.type = 'hidden';
    //         input.name = sales[${index}]; 
    //         input.value = JSON.stringify({
    //             product_id: item.id,
    //             quantity: item.quantity,
    //             price: item.price,
    //             total_price: item.totalPrice
    //         });
    //         container.appendChild(input);
    //     });
    // }
    

    function submitSale() {
        // Implement the logic to submit the sales data
        alert("Sales submitted successfully!");
        cancelSales();
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
