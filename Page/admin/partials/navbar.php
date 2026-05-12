<header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light px-3">

    <!-- tombol sidebar mobile -->
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler" 
           id="headerCollapse" 
           href="javascript:void(0)">
          <i class="ti ti-menu-2 fs-5"></i>
        </a>
      </li>
    </ul>

    <!-- kanan navbar -->
    <div class="navbar-collapse justify-content-end">

      <ul class="navbar-nav flex-row align-items-center gap-2">

        <!-- notif -->
        <li class="nav-item dropdown">
          <a class="nav-link position-relative"
             href="javascript:void(0)"
             id="notifDropdown"
             data-bs-toggle="dropdown">

            <i class="ti ti-bell fs-5"></i>

            <!-- <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border border-light rounded-circle"> -->
            </span>

          </a>

          <div class="dropdown-menu dropdown-menu-end">
            <div class="p-3">
              <h6 class="mb-2">Notifikasi</h6>
              <p class="mb-0 text-muted fs-2">
                Belum ada notifikasi
              </p>
            </div>
          </div>
        </li>

        <!-- profile -->
        <li class="nav-item dropdown">

          <a class="nav-link"
             href="javascript:void(0)"
             id="profileDropdown"
             data-bs-toggle="dropdown">

            <img src="../assets/images/profile/user-1.jpg"
                 alt="profile"
                 width="38"
                 height="38"
                 class="rounded-circle object-fit-cover">

          </a>

          <div class="dropdown-menu dropdown-menu-end">

            <div class="px-3 py-2 border-bottom">
              <h6 class="mb-0">Admin</h6>
              <small class="text-muted">
                SEVShop Dashboard
              </small>
            </div>

            <a href="#"
               class="dropdown-item d-flex align-items-center gap-2">
              <i class="ti ti-user"></i>
              Profile
            </a>

            <a href="#"
               class="dropdown-item d-flex align-items-center gap-2">
              <i class="ti ti-settings"></i>
              Settings
            </a>

            <div class="dropdown-divider"></div>

            <a href="#"
               class="dropdown-item text-danger d-flex align-items-center gap-2">
              <i class="ti ti-logout"></i>
              Logout
            </a>

          </div>
        </li>

      </ul>

    </div>
  </nav>
</header>