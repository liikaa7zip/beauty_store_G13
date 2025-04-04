<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}

// Initialize variables if not set
if (!isset($error)) $error = null;
if (!isset($username)) $username = '';
if (!isset($email)) $email = '';
if (!isset($role)) $role = '';
?>

<h2 id="h2-create-employ">Add New Employee</h2>
<div class="new-form-wrapper">
    <div class="new-form-container">
        <div class="new-image-section">
            <div class="new-image-preview-wrapper" id="newImageOverlay">
                <div class="new-image-overlay">
                    <div class="new-image-placeholder">
                        <svg class="new-upload-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="17 8 12 3 7 8"></polyline>
                            <line x1="12" y1="3" x2="12" y2="15"></line>
                        </svg>
                        <p>Click to upload an image</p>
                    </div>
                </div>
            </div>
            <!-- <input type="file" id="newImageUpload" name="image" style="display: none;"> -->
        </div>

        <?php if ($error): ?>
            <p class="new-error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form id="newAddEmployeeForm" action="/employees/store" method="POST" enctype="multipart/form-data">
            <input type="file" id="newImageUpload" name="image" accept="image/*" style="display: none;">
            <div class="new-form-row">
                <div class="new-form-group">
                    <label for="newUsername">Username</label>
                    <input type="text" id="newUsername" name="username" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="new-form-group">
                    <label for="newPassword">Password</label>
                    <input type="password" id="newPassword" name="password" required>
                </div>
            </div>
            <div class="new-form-row">
                <div class="new-form-group">
                    <label for="newEmail">Email</label>
                    <input type="email" id="newEmail" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="new-form-group">
                    <label for="newRole">Role</label>
                    <select id="newRole" name="role" required>
                        <option value="" disabled selected>Select a role</option>
                        <option value="Admin" <?= $role === 'Admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="Staff" <?= $role === 'Staff' ? 'selected' : '' ?>>Staff</option>
                    </select>
                </div>
            </div>
            <div class="new-form-buttons">
                <button type="button" class="new-btn-cancel" onclick="window.location.href='/employees'">Cancel</button>
                <button type="submit" class="new-btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to handle image upload preview
    const imageUploadInput = document.getElementById('newImageUpload');
    const imageOverlay = document.getElementById('newImageOverlay');

    // Trigger file input when clicking on the overlay
    imageOverlay.addEventListener('click', () => {
        imageUploadInput.click();
    });

    // Update the preview when an image is selected
    imageUploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                // Set the uploaded image as the background of the overlay
                imageOverlay.style.backgroundImage = `url(${e.target.result})`;
                imageOverlay.style.backgroundSize = 'cover';
                imageOverlay.style.backgroundPosition = 'center';
                imageOverlay.querySelector('.new-image-placeholder').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
