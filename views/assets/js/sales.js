let salesData = [];

document.getElementById('sale-product').addEventListener('input', function(e) {
    const input = e.target;
    const list = document.getElementById('magicHouses');
    const options = list.getElementsByTagName('option');
    for (let option of options) {
        if (option.value === input.value) {
            input.setAttribute('data-product-id', option.getAttribute('data-id'));
            input.setAttribute('data-productPrice', option.getAttribute('data-price'));
            input.setAttribute('data-stock', option.getAttribute('data-stock')); // Get stock value
            break;
        }
    }
});

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

    // Update stock in the product's data attribute
    productInput.setAttribute('data-stock', stock - quantityNum); // Subtract quantity from stock

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



    function renderTable(){
        const tbody=document.getElementById("order-list")
        const totalP=document.getElementById("total-price")
        let text = ''
        let total = 0
        if(salesData.length>0){
            salesData.forEach((item)=>{
              total+=item.totalPrice
              text+=`<tr class="text-center">
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                    <td>$${item.totalPrice}</td>
                    </tr>`
            })
            tbody.innerHTML=text;
            totalP.textContent=total
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

    function prepareHiddenInputs() {
         const container = document.getElementById('sales-form');
         container.innerHTML = ""; // Clear old inputs
     
         salesData.forEach((item, index) => {
             let input = document.createElement('input');
             input.type = 'hidden';
             input.name = `sales[${index}]`; // Name must match PHP expected structure
             input.value = JSON.stringify({
                 product_id: item.id,
                 quantity: item.quantity,
                 price: item.price,
                 total_price: item.totalPrice
             });
             container.appendChild(input);
         });
     }
    

    function submitSale() {
        // Implement the logic to submit the sales data
        alert("Sales submitted successfully!");
        cancelSales();
    }

    function submitSales() {
        if (salesData.length === 0) {
            alert("Please add items to cart first");
            return;
        }
    
        prepareHiddenInputs(); // Call this to add hidden inputs
        renderTable();
        document.getElementById('recipeModal').style.display = 'flex';
    }
    
    
    function closeModal() {
        document.getElementById('recipeModal').style.display = 'none'; // Hide modal
    
        // Now submit the form since the modal is closed
        const submitBtn = document.getElementById("hidden-submit");
        if (submitBtn.dataset.pending === "true") {
            submitBtn.dataset.pending = "false"; // Reset flag
            submitBtn.click(); // Trigger actual form submission
        }
    }
    
