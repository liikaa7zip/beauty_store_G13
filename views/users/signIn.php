<?php
// Ensure no output before session_start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    if ($_SERVER['REQUEST_URI'] !== '/dashboard/sell') { // Prevent redirect loop
        header("Location: /dashboard/sell");
        exit();
    }
}

// Initialize error variable
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // Example: Validate credentials
    if ($email === 'admin@example.com' && $password === 'password') {
        // Set session and redirect to the dashboard
        $_SESSION['user_id'] = 1; // Example user ID
        header("Location: /dashboard/sell");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<div class="user-container">
    <div class="form-signIn">
        <form id="signInForm" action="/users/signIn" method="post">
            <h1>Login</h1>

            <!-- Error Message -->
            <?php if (!empty($error)): ?>
                <div id="alertBox" class="error-box">
                    <span id="closeAlert" class="close-btn">&times;</span>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit" id="submit">Login</button>
        </form>
    </div>
</div>