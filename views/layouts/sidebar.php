<aside class="app-sidebar bg-body-secondary shadow">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand" style="padding: 33px;">
        <a href="/dashboard/sell" class="brand-link">
            <!-- <img src="/views/assets/img/lo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" /> -->
            <span class="text">Beauty Store</span>

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
                    <a href="/inventory/products" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Inventory</p>
                    </a>
                </li>
                <li class="nav-item"><a href="/promotion" class="nav-link"><i class="nav-icon bi bi-table"></i>
                        <p>Promotions</p>
                    </a></li>
                <li class="nav-item"><a href="/sales" class="nav-link"><i id="sales" class="bi bi-cash"></i></i></i>
                        <p id="sale-nav">Sales</p>
                    </a></li>
                <li class="nav-item"><a href="/customers" class="nav-link"><i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>Customer</p>
                    </a></li>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                    <li class="nav-item">
                        <a href="/employees" class="nav-link">
                            <i class="nav-icon bi bi-people-fill"></i>
                            <p>User Management</p>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item"><a href="/notification" class="nav-link"><i class="nav-icon bi bi-tree-fill"></i>
                        <p>Notification</p>
                    </a></li>
                <li class="nav-item"><a href="/history" class="nav-link"><i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>Histories</p>
                    </a></li>
            </ul>
        </nav>
    </div>
</aside>
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">