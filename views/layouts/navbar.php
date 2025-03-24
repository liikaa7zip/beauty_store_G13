

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
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
      <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
    </ul>
    <!--end::Start Navbar Links-->
    <!--begin::End Navbar Links-->
    <ul class="navbar-nav">
      <!--begin::Navbar Search-->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="bi bi-search"></i>
        </a>
      </li>
      <!--end::Navbar Search-->
      <!--begin::Messages Dropdown Menu-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
          <i class="bi bi-chat-text"></i>
          <span class="navbar-badge badge text-bg-danger">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <a href="#" class="dropdown-item">
            <!--begin::Message-->
            <div class="d-flex">
              <div class="flex-shrink-0">
                <img
                  src="../../dist/assets/img/user1-128x128.jpg"
                  alt="User Avatar"
                  class="img-size-50 rounded-circle me-3" />
              </div>
              <div class="flex-grow-1">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-end fs-7 text-danger"><i class="bi bi-star-fill"></i></span>
                </h3>
                <p class="fs-7">Call me whenever you can...</p>
                <p class="fs-7 text-secondary">
                  <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!--end::Message-->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!--begin::Message-->
            <div class="d-flex">
              <div class="flex-shrink-0">
                <img
                  src="../../dist/assets/img/user8-128x128.jpg"
                  alt="User Avatar"
                  class="img-size-50 rounded-circle me-3" />
              </div>
              <div class="flex-grow-1">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-end fs-7 text-secondary">
                    <i class="bi bi-star-fill"></i>
                  </span>
                </h3>
                <p class="fs-7">I got your message bro</p>
                <p class="fs-7 text-secondary">
                  <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!--end::Message-->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!--begin::Message-->
            <div class="d-flex">
              <div class="flex-shrink-0">
                <img
                  src="../../dist/assets/img/user3-128x128.jpg"
                  alt="User Avatar"
                  class="img-size-50 rounded-circle me-3" />
              </div>
              <div class="flex-grow-1">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-end fs-7 text-warning">
                    <i class="bi bi-star-fill"></i>
                  </span>
                </h3>
                <p class="fs-7">The subject goes here</p>
                <p class="fs-7 text-secondary">
                  <i class="bi bi-clock-fill me-1"></i> 4 Hours Ago
                </p>
              </div>
            </div>
            <!--end::Message-->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!--end::Messages Dropdown Menu-->
      <!--begin::Notifications Dropdown Menu-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-bs-toggle="dropdown" href="#">
          <i class="bi bi-bell-fill"></i>
          <span class="navbar-badge badge text-bg-warning">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="bi bi-envelope me-2"></i> 4 new messages
            <span class="float-end text-secondary fs-7">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="bi bi-people-fill me-2"></i> 8 friend requests
            <span class="float-end text-secondary fs-7">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
            <span class="float-end text-secondary fs-7">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
        </div>
      </li>
      <!--end::Notifications Dropdown Menu-->
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
            src="/views/assets/img/profile.jpg"
            class="user-image rounded-circle shadow"
            alt="User Image" />
          <span class="d-none d-md-inline"> <?= $_SESSION['user_name'] ? $_SESSION['user_name'] : 'Unknown' ?></span>
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
            <a style="border: 1px solid #ff69b4; margin-top: 10px;" href="/users/signIn" class="btn btn-default btn-flat float-end">Sign out</a>
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
  background: linear-gradient(135deg,rgb(189, 189, 189),rgb(148, 185, 194));
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
</style>
