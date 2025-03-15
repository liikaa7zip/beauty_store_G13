document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("addProductModal");
    var openModalBtn = document.getElementById("addProductBtn"); // The button to open modal
    var closeModalBtn = document.querySelector(".close");

    // Open Modal when clicking the "Add Product" button
    openModalBtn.addEventListener("click", function () {
        modal.classList.add("open"); // Adds the 'open' class to make it visible
    });

    // Close Modal when clicking the 'X' button
    closeModalBtn.addEventListener("click", function () {
        modal.classList.remove("open"); // Removes 'open' class to hide modal
    });

    // Close Modal when clicking outside of it
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("open");
        }
    });
});  