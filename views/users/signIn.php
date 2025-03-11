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
<div class="info">
      <h1>Welcome Back To</h1>
      <h4>Beauty Store System!</h4>
      <p>
      This system allows you to securely log in and manage your beauty store, including:
      </p>
      <ul>
        <li>✔️ Browsing & Managing Products</li>
        <li>✔️ Tracking Stock Levels</li>
        <li>✔️ Generating Sales Reports</li>
      </ul>
    </div>
<div class="form-container">
  <form id="signInForm" action="/users/authenticate" method="post">
    <h1>Sign In</h1>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required>
    
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required>

    <a class="signUp" href="/users/signUp">Sign up</a>
    
    <button type="submit" id="submit">Sign In</button>
  </form>
</div>
</div>

