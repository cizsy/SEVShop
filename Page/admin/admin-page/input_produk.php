<?php 
include '../../../config/database.php';
include '../../../Model/Product.php';
include '../../../Model/artis.php';
include '../../../Model/Kategori.php';
include '../../../Model/Penerbit.php';

$productModel = new Product();
$artistModel = new Artis();
$kategoriModel = new Kategori();
$penerbitModel = new Penerbit();

$id = $_GET['id'] ?? null;
$row = $id ? $productModel->getById($id) : [];

// TAMBAHAN: Ambil data list untuk dropdown select
// Sesuaikan nama function 'getAll()' dengan function yang ada di dalam class Model kamu
$artis_list = $artistModel->readAll(); 
$kategori_list = $kategoriModel->readAll(); 
$penerbit_list = $penerbitModel->readAll(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Siapkan data sesuai struktur
    $data = [
        'name'          => $_POST['nama_produk'],
        'artis_id'      => $_POST['id_artis'],
        'price'         => $_POST['harga'],
        'stock'         => $_POST['stok'],
        'detail'        => $_POST['detail_produk'], // Pastikan ini teks, bukan file
        'thn_terbit'    => $_POST['thn_terbit'],
        'category_id'   => $_POST['id_kategori'],
        'penerbit_id'   => $_POST['id_penerbit'],
        'notice'        => $_POST['notice'] ?? '', 
        'terms'         => $_POST['terms'] ?? '',
        'size'          => $_POST['size'] ?? '',
        'contents'      => $_POST['contents'] ?? '',
        'komentar_id'   => null, 
        'jenis_id'      => null,  
        'gambar_produk' => $row['gambar_produk'] ?? '' 
    ];

    // Handle upload gambar
    if (!empty($_FILES['gambar_produk']['name'])) {
        $gambar = $_FILES['gambar_produk']['name'];
        move_uploaded_file($_FILES['gambar_produk']['tmp_name'], "uploads/" . $gambar);
        $data['gambar_produk'] = $gambar;
    }

    // Eksekusi pakai Model
    if ($id) {
        $result = $productModel->update($id, $data);
    } else {
        $result = $productModel->create($data);
    }

    if ($result) {
        header("Location: index.php?status=success");
        exit;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    <div class="app-topstrip bg-dark py-6 px-3 w-100 d-lg-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center justify-content-center gap-5 mb-2 mb-lg-0">
        </a>

        
      </div>


    </div>
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="../index.html" class="text-nowrap logo-img">
            <img src="../assets/images/logos/logo.svg" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="../index.html" aria-expanded="false">
                <i class="ti ti-atom"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <!-- ---------------------------------- -->
            <!-- Dashboard -->
            <!-- ---------------------------------- -->
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="input_artis.php" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Artis</span>
                </div>
                
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="input_kategori.php" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Kategori</span>
                </div>
                
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="input_penerbit.php" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Penerbit</span>
                </div>
              </a>
            </li>

             <li class="sidebar-item">
              <a class="sidebar-link justify-content-between"  
                href="input_produk.php" aria-expanded="false">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex">
                    <i class="ti ti-aperture"></i>
                  </span>
                  <span class="hide-menu">Produk</span>
                </div>
              </a>
            </li>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler " id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link " href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                <iconify-icon icon="solar:bell-linear" class="fs-6"></iconify-icon>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
              <div class="dropdown-menu dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="message-body">
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 1
                  </a>
                  <a href="javascript:void(0)" class="dropdown-item">
                    Item 2
                  </a>
                </div>
              </div>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
               
              <li class="nav-item dropdown">
                <a class="nav-link " href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="./assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
        <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Form Input Produk</h5>
              <div class="card">
                <fieldset>
                <div class="card-body">
                    <form action="" method="post" id="formProduk" enctype="multipart/form-data">
                    <label class="form-label">Nama Produk</label><br>
                    <input type="text" name="nama_produk" value="<?= $row['nama_produk'] ?? '' ?>" class="form-control"><br><br>

                    <label class="form-label">Artis</label><br>
                    <select name="id_artis" class="form-select" required>
                        <?php while ($a = $artis_list->fetch_assoc()) { ?>
                            <option value="<?= $a['id_artis'] ?>" <?= (isset($row['id_artis']) && $a['id_artis'] == $row['id_artis']) ? 'selected' : '' ?>>
                                <?= $a['nama_artis'] ?>
                            </option>
                        <?php } ?>
                    </select><br><br>

                    <label class="form-label">Harga</label><br>
                    <input type="number" name="harga" value="<?= $row['harga'] ?? 0 ?>" required class="form-control"><br><br>

                    <label class="form-label">Stok</label><br>
                    <input type="number" name="stok" value="<?= $row['stok'] ?? '' ?>" required class="form-control"><br><br>

                    <label class="form-label">Detail produk</label><br>
                    <textarea name="detail_produk" class="form-control" required><?= $row['detail_produk'] ?? '' ?></textarea><br><br>

                    <label class="form-label">Gambar Produk:</label><br>
                    <input type="file" name="gambar_produk" class="form-control" <?= $id ? '' : 'required' ?>><br><br>

                    <label class="form-label">Tahun Terbit:</label><br>
                    <input type="number" name="thn_terbit" value="<?= $row['thn_terbit'] ?? '' ?>" required class="form-control"><br><br>

                    <label class="form-label">Kategori:</label><br>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php while ($k = $kategori_list->fetch_assoc()) { ?>
                            <option value="<?= $k['id_kategori'] ?>" <?= (isset($row['id_kategori']) && $k['id_kategori'] == $row['id_kategori']) ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php } ?>
                    </select><br><br>

                    <label class="form-label">Penerbit:</label><br>
                    <select name="id_penerbit" class="form-select" required>
                        <option value="">-- Pilih Penerbit --</option>
                        <?php while ($pub = $penerbit_list->fetch_assoc()) { ?>
                            <option value="<?= $pub['id_penerbit'] ?>" <?= (isset($row['id_penerbit']) && $pub['id_penerbit'] == $row['id_penerbit']) ? 'selected' : '' ?>>
                                <?= $pub['nama_penerbit'] ?>
                            </option>
                        <?php } ?>
                    </select><br><br>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

</body>

</html>