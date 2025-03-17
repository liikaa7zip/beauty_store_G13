// function toggleDropdown(button) {
//     var dropdown = button.nextElementSibling; // Get the dropdown content
//     dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";

<<<<<<< HEAD
//     // Close dropdown if clicking outside
//     document.addEventListener("click", function (event) {
//         if (!button.contains(event.target) && !dropdown.contains(event.target)) {
//             dropdown.style.display = "none";
//         }
//     }, { once: true }); // Ensures only one event listener runs at a time
// }
=======
    // Close the dropdown when clicking outside
    document.addEventListener("click", function(event) {
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = "none"; // Close the dropdown if the click is outside the button or dropdown
        }
    }, { once: true }); // Ensure this event listener runs only once
}

// Confirmation for Delete action
function confirmDelete(event) {
    if (!confirm("Are you sure you want to delete this product?")) {
        event.preventDefault(); // Prevent the delete action if the user cancels
    }
}

function searchProducts() {
    var input, filter, table, rows, cells, i, j, found;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("productTable");
    rows = table.getElementsByTagName("tr");

    // Loop through all rows (excluding the header)
    for (i = 1; i < rows.length; i++) {
        cells = rows[i].getElementsByTagName("td");
        found = false;

        // Loop through all columns (excluding the Actions column)
        for (j = 0; j < cells.length - 1; j++) { // "- 1" to exclude the last column (Actions)
            if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        // Hide or show the content based on search
        if (found) {
            rows[i].style.opacity = "1"; // Show the row
            rows[i].style.pointerEvents = "auto"; // Enable interaction with the row
        } else {
            rows[i].style.opacity = "0"; // Hide the row content but keep its height
            rows[i].style.pointerEvents = "none"; // Disable interaction with the row
        }
    }

    // Ensure the Actions column stays visible regardless of the search
    showActionsColumn();
}

function showActionsColumn() {
    var table = document.getElementById("productTable");
    var rows = table.querySelectorAll("tr");

    // Ensure the Actions column is visible by resetting styles
    rows.forEach(function(row, index) {
        var cells = row.getElementsByTagName("td");
        if (index !== 0) { // Skip header row
            cells[cells.length - 1].style.opacity = "1"; // Ensure the Actions column is visible
            cells[cells.length - 1].style.pointerEvents = "auto"; // Re-enable interaction with Actions
        }
    });
}




document.getElementById("searchBtn").addEventListener("click", function() {
    let input = document.getElementById("searchInput").value.toLowerCase();
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

>>>>>>> 977ffc5171039955e3f06c849cf82adcef7b70de
