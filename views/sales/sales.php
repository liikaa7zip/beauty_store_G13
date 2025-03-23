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
                <button onclick="cancelSales()" class="cancel-button">Cancel</button>
                <button onclick="submitSales()" class="submit-button">Submit</button>

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
                      <tbody id="order-list">
                        <!-- <tr>
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
                        </tr> -->
                        <tr class="total">
                          <td colspan="3">Total Price</td>
                          <td id="total-price">$9.5</td>
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

<div id="stockModal" class="custom-modal">
     <div id="modalContent" class="modal-content">
         <h2 id="modalMessage" class="modal-message"></h2>
         <button id="closeModalBtn" class="modal-close-btn">Close</button>
     </div>
 </div>
 