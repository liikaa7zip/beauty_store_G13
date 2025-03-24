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
            <th id="quantity">Quantity</th>
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
      <p><strong>Date:</strong> 11/4/25</p>
      <p><strong>Time:</strong> 8:10 AM</p>
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
    <tr class="total">
      <td colspan="3">Total Price</td>
      <td id="total-price">$0.00</td> <!-- Total Price will be updated here -->
    </tr>
  </tbody>
</table>

<div class="total">
  <p><strong>TOTAL:</strong> $<span id="total-amount">0.00</span></p> <!-- Total amount in div -->
</div>

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

<div id="stockModal" class="custom-modal">
    <div id="modalContent" class="modal-content">
        <h2 id="modalMessage" class="modal-message"></h2>
        <button id="closeModalBtn" class="modal-close-btn">Close</button>
    </div>
</div>


