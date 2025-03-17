<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
?>

<div class="products_container">
    <h1 id="h1-products">Products Page</h1>

    <div class="container mt-4">
    <div class="table-container">
  <!-- Custom Search Bar -->
  <div class="table-header">
    <input type="text" id="searchInput" placeholder="Search for products..." onkeyup="searchProducts()">
    <button id="searchBtn">Search</button>
</div>


  <!-- Table -->
  <table id="productTable" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Stock</th>
        <th>Category</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product): ?>
        <tr>
          <td><?= htmlspecialchars($product['name']) ?></td>
          <td><?= htmlspecialchars($product['stocks']) ?></td>
          <td><p><?= htmlspecialchars($product['category_name'] ?? 'N/A') ?></p></td>
          <td class="<?= ($product['status'] === 'low-stock') ? 'status-low-stock' : 'status-instock' ?>">
    <?= ucfirst(htmlspecialchars($product['status'])) ?>
</td>

          <td>
                <div class="dropdown">
                    <button class="dropbtn" onclick="toggleDropdown(this)">
                        <span class="material-symbols-outlined">more_horiz</span>
                    </button>
                    <div class="dropdown-content">
                        <a href="/inventory/edit/<?= $product['id'] ?>">
                            <span class="material-symbols-outlined">border_color</span> Edit
                        </a>
                        <a href="/inventory/delete/<?= $product['id'] ?>" onclick="return confirmDelete(event);">
                            <span class="material-symbols-outlined">delete</span> Delete
                        </a>
                    </div>
                </div>
            </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<div class="pagination" id="pagination"></div>
        <div class="stocks-container">
        <h3>Stock summary:</h3>
        <div class="stock-summary">
            <div class="card">
                <div class="icon">📦</div>
                <p>Total Products</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <div class="icon low-stock">🔻</div>
                <p>Low-stocks</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <div class="icon in-stock">📈</div>
                <p>In-stocks</p>
                <h3>0.00</h3>
            </div>
            <div class="card">
                <p>Last Day Update</p>
                <h3 id="lastUpdate"></h3>
            </div>
            <div class="card">
                <div class="icon waste">🗑️</div>
                <p>Waste</p>
            </div>
            <a id="add-products" href="/inventory/create">
                <div class="card">
                    <div class="icon add">➕</div>
                        <p>Add products</p>
                </div>
            </a>
        </div>
    </div>

</div>
</div>





<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom JavaScript -->
<script>
$(document).ready(function() {
    var table = $('#productTable').DataTable({
        "pageLength": 10, // Show 8 products per page
        "paging": true,  // Enable pagination
        "info": true,    // Show the information (e.g., "Showing 1 to 8 of 25 entries")
        "lengthChange": false, // Disable the option to change the number of items per page
        "dom": '<"top"i>rt<"bottom"lp><"clear">' // Custom layout (pagination at bottom)
    });

    document.getElementById("searchInput").addEventListener("keyup", function() {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#productTable tbody tr");

    rows.forEach(row => {
        let name = row.cells[0].textContent.toLowerCase();
        let category = row.cells[2].textContent.toLowerCase();

        if (name.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    const lastUpdateElement = document.getElementById('lastUpdate');
    const lastUpdateCard = document.getElementById('lastUpdateCard');
    const addProductsCard = document.querySelector('.card .icon.add')?.closest('.card');

    if (!lastUpdateElement || !lastUpdateCard || !addProductsCard) {
        console.error('One or more elements not found:', { lastUpdateElement, lastUpdateCard, addProductsCard });
        return;
    }

    function getCurrentDateTime() {
        const now = new Date();
        return `${now.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' })}, ${now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })}`;
    }

    function updateLastUpdate() {
        const previousUpdate = localStorage.getItem('lastUpdate') || 'No previous update';
        localStorage.setItem('previousUpdate', previousUpdate);

        const currentTime = getCurrentDateTime();
        lastUpdateElement.textContent = currentTime;
        localStorage.setItem('lastUpdate', currentTime);

        console.log('Last update set to:', currentTime);
        alert('Last update set to: ' + currentTime);
    }

    // Initialize last update on page load
    const storedLastUpdate = localStorage.getItem('lastUpdate') || getCurrentDateTime();
    lastUpdateElement.textContent = storedLastUpdate;
    localStorage.setItem('lastUpdate', storedLastUpdate);

    console.log('Initial last update:', lastUpdateElement.textContent);

    // Add click event listener to update last update time
    addProductsCard.addEventListener('click', updateLastUpdate);

    function showPreviousUpdate(event) {
        event.preventDefault();
        event.stopPropagation();

        const previousUpdate = localStorage.getItem('previousUpdate') || 'No previous update available';
        console.log('Clicked last update card, previous update:', previousUpdate);
        alert('Previous Update: ' + previousUpdate);
    }

    // Attach click event listeners to both last update card and its text
    lastUpdateCard.addEventListener('click', showPreviousUpdate);
    lastUpdateElement.addEventListener('click', showPreviousUpdate);
});

</script>

<!-- <script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll("#productTable tbody tr");

    rows.forEach(row => {
        let name = row.cells[0].textContent.toLowerCase();
        let category = row.cells[2].textContent.toLowerCase();

        if (name.includes(input) || category.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

            <label for="description">Description:</label>
            <input type="text" id="description" name="description">


            <button type="submit" class="btn-submit">Add Product</button>
        </form>
    </div>
</div>


<script>
    // Ensure DOM is fully loaded before running the script
    document.addEventListener('DOMContentLoaded', function() {
        // Get the last update element and add products card
        const lastUpdateElement = document.getElementById('lastUpdate');
        const lastUpdateCard = document.getElementById('lastUpdateCard');
        const addProductsCard = document.querySelector('.card .icon.add').closest('.card');

        // Check if elements exist
        if (!lastUpdateElement || !lastUpdateCard || !addProductsCard) {
            console.error('One or more elements not found:', {
                lastUpdateElement,
                lastUpdateCard,
                addProductsCard
            });
            return;
        }

        // Function to get the current date and time in the desired format
        function getCurrentDateTime() {
            const now = new Date();
            return `${now.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' })}, ${now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true })}`;
        }

        // On page load, set the last update time from localStorage
        const storedLastUpdate = localStorage.getItem('lastUpdate');
        if (storedLastUpdate) {
            lastUpdateElement.textContent = storedLastUpdate;
        } else {
            lastUpdateElement.textContent = getCurrentDateTime();
            localStorage.setItem('lastUpdate', lastUpdateElement.textContent);
        }
        console.log('Initial last update:', lastUpdateElement.textContent);

        // Update last update time when the "Add products" card is clicked
        addProductsCard.addEventListener('click', function() {
            const currentTime = getCurrentDateTime();
            lastUpdateElement.textContent = currentTime;
            localStorage.setItem('lastUpdate', currentTime);
            console.log('Last update updated to:', currentTime);
            alert('Last update set to: ' + currentTime);
        });

        // Optional: Show the previous update when the last update card is clicked (if desired)
        lastUpdateCard.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            const previousUpdate = localStorage.getItem('previousUpdate') || 'No previous update';
            console.log('Clicked last update card, previous update:', previousUpdate);
            if (previousUpdate !== 'No previous update') {
                alert('Previous Update: ' + previousUpdate);
            } else {
                alert('No previous update available');
            }
        });

        // Ensure the h3 inside the card also triggers the click (if desired)
        lastUpdateElement.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            const previousUpdate = localStorage.getItem('previousUpdate') || 'No previous update';
            console.log('Clicked last update text, previous update:', previousUpdate);
            if (previousUpdate !== 'No previous update') {
                alert('Previous Update: ' + previousUpdate);
            } else {
                alert('No previous update available');
            }
        });
    });
</script>