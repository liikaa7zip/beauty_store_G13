<?php
// Ensure no output before session_start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard/sell");
    exit();
}
?>

<div class="user-container">
    <div class="form-signIn">
        <?php if (isset($_SESSION['success'])): ?>
            <div id="successBox" class="success-box">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div id="alertBox" class="error-box">
                <span id="closeAlert" class="close-btn">&times;</span>
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form id="signInForm" action="/users/authenticate" method="post">
            <h1>Sign In</h1>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password"  required>
            <button type="submit" id="submit">Sign In</button>
        </form>
    </div>
</div>