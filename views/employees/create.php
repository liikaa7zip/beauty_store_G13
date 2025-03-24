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
<div class="form-wrapper">

        <div class="form-container">
            <!-- <h2>Add New Employees</h2> -->
            <div class="image-section">
            <div class="image-section">
    <div class="image-preview-wrapper" id="imageOverlay">
        <img src="/public/images/placeholder.jpg" alt="Employee Image" id="imagePreview" class="image-preview">
        <div class="image-overlay">
            <span>Change Image</span> 
        </div>
    </div>
    <input type="file" id="imageUpload" name="image" accept="image/*" style="display: none;">
</div>
            <?php if ($error): ?>
                <p class="error-message"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <form id="addEmployeeForm" action="/employees/store" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="" disabled selected>Select a role</option>
                            <option value="Admin" <?= $role === 'Admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="Staff" <?= $role === 'Staff' ? 'selected' : '' ?>>Staff</option>
                        </select>
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="button" class="btn-cancel" onclick="window.location.href='/employees'">Cancel</button>
                    <button type="submit" class="btn-primary">Submit</button>
                </div>
            </form>
            <div class="confirmation-message" id="confirmationMessage">
                Employee added successfully! <a href="/employees/add" style="color: #2e7d32; text-decoration: underline;">Add another employee</a>
            </div>
        </div>
    </div>