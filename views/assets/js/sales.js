let salesData = [];
document.getElementById('sale-product').addEventListener('input', function(e) {
  const input = e.target;
  const list = document.getElementById('magicHouses');
  const options = list.getElementsByTagName('option');
  for (let option of options) {
      if (option.value === input.value) {
          input.setAttribute('data-product-id', option.getAttribute('data-id'));
          input.setAttribute('data-productPrice', option.getAttribute('data-price'));
          break;
      }
  }
});
function addSaleToTable() {
    let product = document.getElementById("sale-product").value.trim();
    let productId = document.getElementById("sale-product").getAttribute('data-product-id');
    let productPrice = document.getElementById("sale-product").getAttribute('data-productPrice');
    let quantity = document.getElementById("sale-quantity").value.trim();

    // Check if product name and quantity are not empty
    if (product !== "" && quantity !== "") {
        let table = document.getElementById("sales-record-table");
        let tbody = table.querySelector("tbody");    // Display table and buttons if hidden
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
        const newData = {id:productId, name:product, quantity:quantity,price:productPrice,totalPrice:productPrice*quantity};
        salesData.push(newData);

        // Clear the input fields
        document.getElementById("sale-product").value = "";
        document.getElementById("sale-quantity").value = "";
        console.log(salesData);
        
    } else {
        // If inputs are empty, alert the user
        alert("Please enter both product name and quantity.");
    }
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
    table.style.display = "none";

    // Hide the buttons
    document.getElementById("table-buttons").style.display = "none";
    salesData.length=0
    console.log(salesData);
    
}

function submitSales() {
    // Implement the logic to submit the sales data
    alert("Sales submitted successfully!");
    cancelSales();
}

function submitSales() {
// Show the modal when the button is clicked
renderTable()
document.getElementById('recipeModal').style.display = 'flex';
}

function closeModal() {
// Close the modal
document.getElementById('recipeModal').style.display = 'none';
}