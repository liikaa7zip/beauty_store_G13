document.addEventListener("DOMContentLoaded", function () {
    let successBox = document.getElementById("successBox");
    let alertBox = document.getElementById("alertBox");
    let closeBtn = document.getElementById("closeAlert");

    // Auto-hide success message after 3 seconds
    if (successBox) {
        setTimeout(() => {
            successBox.style.opacity = "0";
            setTimeout(() => { successBox.style.display = "none"; }, 500);
        }, 3000);
    }

    // Auto-hide error message after 3 seconds
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.opacity = "0";
            setTimeout(() => { alertBox.style.display = "none"; }, 500);
        }, 3000);
    }

    // Allow user to close error message manually
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            alertBox.style.opacity = "0";
            setTimeout(() => { alertBox.style.display = "none"; }, 300);
        });
    }
});