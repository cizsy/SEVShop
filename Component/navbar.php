<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
  <div class="kotak-navbar">

    <a class="navbar-brand" href="/index.php?Page=home">
      <img src="/logo/Shopnavbar-removebg-preview.png" alt="Logo" width="auto" height="45">
    </a>

    <form class="search-bar" action="/index.php" method="get">
      <input type="hidden" name="Page" value="search_artis">

      <div class="search-wrap">
        <i class="search-icon bi bi-search"></i>
        <input type="search"
               class="search-input"
               name="q"
               placeholder="Search Artist"
               aria-label="Search"
               required>
      </div>
    </form>

    <div class="navbar-options" style="height: 40px;">

      <a href="/index.php?Page=wishlist" class="icon-wishlist" title="Wishlist">
        <i class="bi bi-heart"></i>
      </a>

      <a href="/index.php?Page=cart" class="icon-cart" title="Cart">
        <i class="bi bi-cart2"></i>
      </a>

      <?php if (isset($_SESSION['id_user'])) { ?>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
          <a href="/Page/admin/index.php" class="login-button" title="Dashboard">
            Dashboard
          </a>
        <?php } ?>

        <span class="login-button" style="cursor: default;">
          <?= htmlspecialchars($_SESSION['nama_user'] ?? 'User', ENT_QUOTES); ?>
        </span>

        <a href="/logout.php" class="login-button" title="Logout">
          Logout
        </a>

      <?php } else { ?>

        <a href="/index.php?Page=login" class="login-button" title="Log In">
          Log In
        </a>

      <?php } ?>

    </div>
  </div>
</nav>