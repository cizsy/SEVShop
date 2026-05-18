<?php include __DIR__ . '/../auth_check.php'; ?>
<!doctype html>
<html lang="en">

<?php include __DIR__ . '/head.php'; ?>

<body>
  <div class="page-wrapper" id="main-wrapper"
       data-layout="vertical"
       data-navbarbg="skin6"
       data-sidebartype="full"
       data-sidebar-position="fixed"
       data-header-position="fixed">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="body-wrapper">
      <?php include __DIR__ . '/navbar.php'; ?>

      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <?= $content ?? '' ?>
        </div>
      </div>
    </div>
  </div>

  <?php include __DIR__ . '/script.php'; ?>

</body>
</html>