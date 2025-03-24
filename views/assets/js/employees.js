/*
 * Copyright (c) 2025 Your Name. All rights reserved.
 * This code is for personal use and may not be redistributed without permission.
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (event) {
            // Get form field values
            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const role = document.getElementById('role').value;

            // Custom validation
            let errors = [];

            if (username.length < 3) {
                errors.push('Username must be at least 3 characters long.');
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errors.push('Please enter a valid email address.');
            }

            if (password.length < 6) {
                errors.push('Password must be at least 6 characters long.');
            }

            if (!role) {
                errors.push('Please select a role.');
            }

            // If there are errors, prevent form submission and display them
            if (errors.length > 0) {
                event.preventDefault();
                const errorContainer = document.createElement('div');
                errorContainer.className = 'error-message';
                errorContainer.innerHTML = errors.join('<br>');
                
                // Remove any existing error messages
                const existingError = document.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                // Add the new error message
                form.prepend(errorContainer);
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const imageOverlay = document.getElementById('imageOverlay');
    const form = document.getElementById('addEmployeeForm');
    const confirmationMessage = document.getElementById('confirmationMessage');

    // ✅ Click image area to open file selector
    if (imageOverlay && imageUpload) {
        imageOverlay.addEventListener('click', function() {
            imageUpload.click();
        });
    }

    // ✅ Show selected image in preview
    if (imageUpload && imagePreview) {
        imageUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // ✅ Form validation and submission
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const username = document.getElementById('username').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const role = document.getElementById('role').value;
            const image = imageUpload.files[0];

            if (!username || !email || !password || !role || !image) {
                alert('Please fill in all fields and select an image.');
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return;
            }

            // ✅ Show confirmation message
            if (confirmationMessage) {
                confirmationMessage.style.display = 'block';
            }

            // ✅ Reset form and image preview
            form.reset();
            imagePreview.src = '/public/images/placeholder.jpg';

            // Uncomment for actual form submission
            // form.submit();
        });
    } else {
        console.warn('Form with ID "addEmployeeForm" not found');
    }
});
