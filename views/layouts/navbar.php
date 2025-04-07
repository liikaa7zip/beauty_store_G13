<nav class="app-header navbar navbar-expand bg-body">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list"></i> 
        </a>
      </li>

    </ul>
    <!--end::Start Navbar Links-->

    <!--begin::End Navbar Links-->
    <ul class="navbar-nav">

      <!--begin::Fullscreen Toggle-->
      <li class="nav-item">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
        </a>
      </li>
      <!--end::Fullscreen Toggle-->
      <!--begin::User Menu Dropdown-->
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
          <img
            src="<?= !empty($_SESSION['image']) ? htmlspecialchars($_SESSION['image']) : '/views/assets/img/default-profile.jpg' ?>"
            class="user-image rounded-circle shadow"
            alt="User Image" />
          <span class="d-none d-md-inline"> <?= htmlspecialchars($_SESSION['user_name'] ?? 'Unknown') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="user-header text-bg-primary">
            <img
              src="/views/assets/img/profile.jpg"
              class="rounded-circle shadow"
              alt="User Image" />
            <p style="font-size: 22px;">
              <?= $_SESSION['user_name'] ? $_SESSION['user_name'] : 'Unknown' ?>
              <small>Member since Nov. 2023</small>
            </p>
          </li>
          <!--end::User Image-->
          <!--begin::Menu Body-->
          <li class="user-body">
            <!--begin::Row-->
            <div class="row">
              <div class="col-4 text-center"><a href="#">Followers</a></div>
              <div class="col-4 text-center"><a href="#">Sales</a></div>
              <div class="col-4 text-center"><a href="#">Friends</a></div>
            </div>
            <!--end::Row-->
          </li>
          <!--end::Menu Body-->
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a style="border: 1px solid #ff69b4; margin-top: 10px;"
              href="#"
              class="btn btn-default btn-flat float-end"
              data-bs-toggle="modal"
              data-bs-target="#signOutModal">
              Sign out
            </a>
          </li>
          <!--end::Menu Footer-->
        </ul>
      </li>
      <!--end::User Menu Dropdown-->
    </ul>
    <!--end::End Navbar Links-->
  </div>
  <!--end::Container-->
</nav>
<div class="modal fade" id="signOutModal" tabindex="-1" aria-labelledby="signOutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signOutModalLabel">Confirm Sign Out</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to sign out?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="/users/logout" class="btn btn-danger">Sign Out</a>
      </div>
    </div>
  </div>
</div>
<style>
  /* User Menu Dropdown Styles */
  .user-menu .dropdown-menu {
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    border: none;
    overflow: hidden;
  }

  .user-header {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, rgb(189, 189, 189), rgb(148, 185, 194));
    color: #fff;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .user-header img {
    width: 80px;
    height: 80px;
    border: 3px solid white;
  }

  .user-header p {
    margin-top: 10px;
    font-weight: bold;
  }

  .user-body .row {
    padding: 10px 0;
  }

  .user-body a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .user-body a:hover {
    color: #ff69b4;
  }

  .user-footer {
    padding: 10px;
    background: #f8f9fa;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
  }

  .user-footer a {
    text-decoration: none;
    font-weight: 500;
    padding: 8px 15px;
    border-radius: 5px;
    transition: background 0.3s;
  }

  .user-footer .btn {
    color: #fff;
    border: none;
  }

  .user-footer .btn:hover {
    background: #ff85a2;
  }

  .app-main {
    width: 100%;
    height: 90vh;
    /* Full height of the viewport */
    overflow: auto;
    /* Allow scrolling if content overflows */
    display: flex;
    flex-direction: column;
    margin: 0;
    /* Remove any default margins */
    padding: 0;
    /* Remove any default padding */
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Ensure Bootstrap dropdown is initialized
    const dropdownElements = document.querySelectorAll('.dropdown-toggle');
    dropdownElements.forEach(function(dropdown) {
      new bootstrap.Dropdown(dropdown);
    });

    const userMenu = document.querySelector(".user-menu .nav-link");
    const dropdown = document.querySelector(".user-menu .dropdown-menu");

    userMenu.addEventListener("click", function(event) {
      event.preventDefault(); // Prevent default anchor behavior
      dropdown.classList.toggle("show"); // Toggle visibility

      // Close dropdown when clicking outside
      document.addEventListener("click", function closeDropdown(e) {
        if (!userMenu.contains(e.target) && !dropdown.contains(e.target)) {
          dropdown.classList.remove("show");
          document.removeEventListener("click", closeDropdown);
        }
      });
    });
  });
</script>