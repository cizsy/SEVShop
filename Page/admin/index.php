<?php
$title = "Dashboard";

ob_start();
?>

<div class="card">
  <div class="card-body">
    <h4 class="fw-semibold mb-2">Dashboard</h4>
    <p class="text-muted mb-0">
      Selamat datang di admin panel SEVShop.
    </p>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>