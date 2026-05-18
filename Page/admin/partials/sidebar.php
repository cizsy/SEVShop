<?php
$base_url = "/Page/admin/";
?>

<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between px-3 py-3">
      <a href="/index.php" class="text-nowrap logo-img text-decoration-none">
        <div class="d-flex align-items-center mx-4">
          <img src="/logo/Shopnavbar-removebg-preview.png" width="150" alt="logo" />
        </div>
      </a>

      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-5"></i>
      </div>
    </div>

    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <li class="nav-small-cap mb-2">
          <div class="d-flex align-items-center gap-2 px-2">
            <iconify-icon icon="solar:menu-dots-linear" class="fs-4"></iconify-icon>
            <span class="hide-menu fw-semibold">MENU</span>
          </div>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>index.php">
            <i class="ti ti-layout-dashboard"></i>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>input_artis.php">
            <i class="ti ti-user"></i>
            <span class="hide-menu">Artis</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>input_kategori.php">
            <i class="ti ti-category"></i>
            <span class="hide-menu">Kategori</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>input_penerbit.php">
            <i class="ti ti-building-store"></i>
            <span class="hide-menu">Penerbit</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>input_produk.php">
            <i class="ti ti-package"></i>
            <span class="hide-menu">Produk</span>
          </a>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link d-flex align-items-center gap-3" href="<?= $base_url ?>viewUser.php">
            <i class="ti ti-users"></i>
            <span class="hide-menu">User</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>