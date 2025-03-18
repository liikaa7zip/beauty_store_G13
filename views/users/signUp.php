<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
  // Redirect to the dashboard if already logged in
  header("Location: /dashboard/sell");
  exit();
}

// If not logged in, show the sign-up form
?>

<div class="user-container">
  <div class="form-container">
    <form id="signInForm" action="/users/store" method="post">
      <h1>Register</h1>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="error-box">
          <?php echo $_SESSION['error']; ?>
          <span class="close-btn">&times;</span>
        </div>
      <?php endif; ?>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text"
          id="username"
          name="username"
          placeholder="Enter your username"
          required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email"
          id="email"
          name="email"
          placeholder="Enter your email"
          required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          required>
      </div>

      <button type="submit" id="submit">Register</button>

      <p>Already have an account?<a href="/users/signIn">Login</a></p>
    </form>
  </div>
</div>