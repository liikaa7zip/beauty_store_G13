<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user_id'])) :
?>
  <div class="app-wrapper">


    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
          <img src="/views/assets/img/lo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
          <span class="brand-text fw-light">Beauty Store</span>
        </a>
      </div>
      <div class="sidebar-wrapper bg-white">
        <nav class="mt-2">
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
            <li class="nav-item menu-open">
              <a href="/dashboard/sell" class="nav-link active">
                <i class="nav-icon bi bi-speedometer"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-box-seam-fill"></i>
                <p>Inventory<i class="nav-arrow bi bi-chevron-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="/inventory/products" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                    <p>Products</p>
                  </a></li>
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-circle"></i>
                    <p>Categories</p>
                  </a></li>
              </ul>
            </li>
            <li class="nav-item"><a href="/promotion" class="nav-link"><i class="nav-icon bi bi-table"></i>
                <p>Promotions</p>
              </a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-clipboard-fill"></i>
                <p>Expiration</p>
              </a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-tree-fill"></i>
                <p>Notification</p>
              </a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon bi bi-clipboard-fill"></i>
                <p>Histories</p>
              </a></li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon bi bi-box-arrow-in-right"></i>
                <p>Auth<i class="nav-arrow bi bi-chevron-right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="/users/signUp" class="nav-link"><i class="nav-icon bi bi-box-arrow-in-right"></i>
                    <p>SignOut</p>
                  </a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  <!-- </div> -->
  <main class="app-main">
  <?php
endif;
  ?>