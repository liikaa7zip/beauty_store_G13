function toggleDropdown(button) {
    var dropdown = button.nextElementSibling; // Get the dropdown content
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";

    // Close dropdown if clicking outside
    document.addEventListener("click", function (event) {
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = "none";
        }
    }, { once: true }); // Ensures only one event listener runs at a time
}
