<?php
require_once '../../../config/database.php';
// Opsional: Panggil class Artis kamu di sini jika ingin pakai OOP
?>

<!doctype html>
<html lang="en">
<?php include __DIR__ . '/head.php'; ?>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <?php include __DIR__ . '/sidebar.php'; ?>

    <div class="body-wrapper">
      
      <?php include __DIR__ . '/navbar.php'; ?>

      <div class="body-wrapper-inner">
        <div class="container-fluid">
          
          <div class="d-flex justify-content-end mb-3">
            <a href="view_artis.php" class="btn text-white" style="background-color:#1E4ED8; border-radius:8px; padding:8px 18px;">
              Lihat Data
            </a>
          </div>

          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Form Input Artis</h5>
              <div class="card">
                <div class="card-body">
                  <form action="../../../Controller/Artis_controller.php" method="post">
                    <label class="form-label">Nama Artis</label><br>
                    <input type="text" name="nama_artis" required class="form-control"><br>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div> </div> </div> </div> <?php include __DIR__ . '/script.php'; ?>
</body>
</html>