<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controller/CartController.php';
$navCartCtrl = new CartController();
$cartItemCount = $navCartCtrl->getCartCount();
?>

<nav class="navbar">
  <div class="kotak-navbar">

    <a class="navbar-brand d-flex align-items-center" href="/index.php?Page=home">
      <img src="/logo/Shopnavbar-removebg-preview.png" alt="SEVShop Logo" height="42">
    </a>

    <form class="search-bar" action="/index.php" method="get">
      <input type="hidden" name="Page" value="search">

      <div class="search-wrap">
        <i class="search-icon bi bi-search"></i>
        <input type="search"
               class="search-input"
               name="q"
               value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES); ?>"
               placeholder="Cari album, lightstick, photocard, atau artis favoritmu..."
               aria-label="Search">
      </div>
    </form>

    <div class="navbar-options">

      <a href="/index.php?Page=search" class="nav-icon-link" title="Jelajahi Produk">
        <i class="bi bi-grid-fill"></i>
        <span class="d-none d-lg-inline fs-7 ms-1">Katalog</span>
      </a>

      <a href="/index.php?Page=tracking" class="nav-icon-link" title="Lacak Pesanan">
        <i class="bi bi-truck"></i>
        <span class="d-none d-lg-inline fs-7 ms-1">Lacak</span>
      </a>

      <a href="/index.php?Page=wishlist" class="nav-icon-link position-relative" title="Wishlist">
        <i class="bi bi-heart"></i>
        <span class="badge-count" id="navWishlistBadge" style="display: none;">0</span>
      </a>

      <a href="/index.php?Page=cart" class="nav-icon-link position-relative" title="Keranjang Belanja">
        <i class="bi bi-bag"></i>
        <span class="badge-count" id="navCartBadge" <?= $cartItemCount > 0 ? '' : 'style="display:none;"'; ?>>
          <?= $cartItemCount; ?>
        </span>
      </a>

      <?php if (isset($_SESSION['id_user'])) { ?>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
          <a href="/Page/admin/index.php" class="login-button admin-badge" title="Dashboard Admin">
            <i class="bi bi-speedometer2 me-1"></i> Admin
          </a>
        <?php } ?>

        <a href="/index.php?Page=orders" class="login-button user-profile-btn" title="Pesanan Saya">
          <i class="bi bi-person-circle me-1"></i>
          <?= htmlspecialchars($_SESSION['nama_user'] ?? 'User', ENT_QUOTES); ?>
        </a>

        <a href="/logout.php" class="login-button logout-btn" title="Logout">
          <i class="bi bi-box-arrow-right"></i>
        </a>

      <?php } else { ?>

        <a href="/index.php?Page=login" class="login-button" title="Log In">
          <i class="bi bi-person me-1"></i> Masuk
        </a>

      <?php } ?>

    </div>
  </div>
</nav>

<script>
  // Sync wishlist badge from localStorage if present
  function syncNavBadges() {
    try {
      const savedWishlist = JSON.parse(localStorage.getItem('sev_wishlist') || '{}');
      const wishlistCount = Object.keys(savedWishlist).length;
      const wishlistBadge = document.getElementById('navWishlistBadge');
      if (wishlistBadge) {
        if (wishlistCount > 0) {
          wishlistBadge.textContent = wishlistCount;
          wishlistBadge.style.display = 'flex';
        } else {
          wishlistBadge.style.display = 'none';
        }
      }
    } catch(e) {}
  }
  document.addEventListener('DOMContentLoaded', syncNavBadges);
  window.addEventListener('wishlistUpdated', syncNavBadges);
</script>