function toggleDropdown(button) {
    var dropdown = button.nextElementSibling; // Get the dropdown content (the div with class 'dropdown-content')
    
    // Toggle the display of the dropdown content
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none"; // Hide the dropdown if it's already visible
    } else {
        dropdown.style.display = "block"; // Show the dropdown if it's hidden
    }

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
