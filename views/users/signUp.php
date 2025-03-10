<div class="container">
    <div class="info">
      <h1>Welcome To</h1>
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
      <form id="signInForm" action="/users/store" method="post">
        <h1>Sign Up</h1>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
        
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Enter your email" required>
        
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <label for="role">Role</label>
        <select id="role" name="role" required>
          <option class="role" value="">Select your role</option>
          <option value="admin">Admin</option>
          <option value="manager">Manager</option>
          <option value="staff">Staff</option>
        </select>

        <a class="signIn" href="/users/signIn">Sign in</a>
        
        <button type="submit" id="submit">Sign Up</button>
      </form>
    </div>
</div>