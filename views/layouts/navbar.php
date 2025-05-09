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
            src="<?= !empty($_SESSION['image']) ? htmlspecialchars($_SESSION['image']) : 'https://cdn-icons-png.flaticon.com/512/149/149071.png' ?>"
            class="user-image rounded-circle shadow"
            alt="User Image" />
          <span class="d-none d-md-inline"> <?= htmlspecialchars($_SESSION['user_name'] ?? 'Unknown') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <!--begin::User Image-->
          <li class="user-header text-bg-primary">
          <img
            src="<?= !empty($_SESSION['image']) ? htmlspecialchars($_SESSION['image']) : "https://cdn-icons-png.flaticon.com/512/149/149071.png" ?>"
            class="user-image rounded-circle shadow"
            alt="User Image" />
            <p style="font-size: 22px;">
              <?= $_SESSION['user_name'] ? $_SESSION['user_name'] : 'Unknown' ?>
              <small>Role: <?= isset($_SESSION['role']) ? ($_SESSION['role'] === 'admin' ? 'Admin' : 'Staff') : 'Not set' ?></small>
            </p>
          </li>
          <!--end::User Image-->
          <!--begin::Menu Body-->
          <li class="user-body">
            <!--begin::Row-->
            <div class="row">
              <div class="col-4 text-center"><a href="/notification">Notification</a></div>
              <div class="col-4 text-center" ><a href="/sales">Sales</a></div>
              <div class="col-4 text-center" ><a href="/history" style="margin-left: -55%;">Histories</a></div>
            </div>
            <!--end::Row-->
          </li>
          <!--end::Menu Body-->
          <!--begin::Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat"></a>
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

  /* User Menu Dropdown Styles */
.user-menu .dropdown-menu {
  border-radius: 10px;
  box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
  border: none;
  overflow: hidden;
  min-width: 250px;
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
  overflow: auto;
  display: flex;
  flex-direction: column;
  margin: 0;
  padding: 0;
}

/* Responsive on Mobile */
@media (max-width: 576px) {
  .user-menu .dropdown-menu {
    width: 95vw !important;
    right: 2.5% !important;
    left: auto !important;
    transform: none !important;
    top: 100% !important;
    margin-top: 5px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0,0,0,0.2);
  }
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

  // Hide the modal
function hideModal() {
    document.getElementById('category-modal').style.display = 'none';
}


document.querySelectorAll('.dropdown-toggle').forEach(button => {
  button.addEventListener('click', function(e) {
    e.stopPropagation();
    
    document.querySelectorAll('.dropdown.active').forEach(dropdown => {
      if (dropdown !== this.parentElement) {
        dropdown.classList.remove('active');
      }
    });
    
    this.parentElement.classList.toggle('active');
  });
});


document.addEventListener('click', function() {
  document.querySelectorAll('.dropdown.active').forEach(dropdown => {
    dropdown.classList.remove('active');
  });
});
</script>