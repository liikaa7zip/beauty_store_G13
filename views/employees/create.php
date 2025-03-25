<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}



if (!isset($error)) $error = null;
if (!isset($username)) $username = '';
if (!isset($email)) $email = '';
if (!isset($role)) $role = '';


?>
<h2>Add New Employees</h2>
<div class="new-form-wrapper">
    <div class="new-form-container">
        <div class="new-image-section">
            <div class="new-image-preview-wrapper" id="newImageOverlay">
                
                <div class="new-image-overlay">
                    
                </div>
            </div>
            <input type="file" id="newImageUpload" name="image" accept="image/*" style="display: none;">
        </div>

        <?php if ($error): ?>
            <p class="new-error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form id="newAddEmployeeForm" action="/employees/store" method="POST" enctype="multipart/form-data">
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
