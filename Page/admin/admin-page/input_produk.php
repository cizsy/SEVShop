<?php include '../../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

// ambil data foreign key
$artis = $conn->query("SELECT id_artis, nama_artis FROM artis");
$kategori = $conn->query("SELECT id_kategori, jenis_kategori FROM kategori");
$penerbit = $conn->query("SELECT id_penerbit, nama_penerbit FROM penerbit");

$id = $_GET['id']; 
$q = "SELECT * FROM produk WHERE id_produk ='id'";
$result = $conn->query($q);
$row = $result->fetch_assoc(); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_produk = $_POST['nama_produk'];
    $id_artis = $_POST['id_artis'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $detail = $_POST['detail'];
    $thn_terbit = $_POST['thn_terbit'];
    $id_kategori = $_POST['id_kategori'];
    $id_penerbit = $_POST['id_penerbit'];

    // upload gambar
    $gambar = $_FILES['gambar_produk']['name'];
    $tmp = $_FILES['gambar_produk']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $gambar);

    // prepared statement
    $stmt = $conn->prepare("
        INSERT INTO produk 
        (nama_produk, id_artis, harga, stok, detail, gambar_produk, thn_terbit, id_kategori, id_penerbit)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sidissiiii",
        $nama_produk,
        $id_artis,
        $harga,
        $stok,
        $detail,
        $gambar,
        $thn_terbit,
        $id_kategori,
        $id_penerbit
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
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
                <div class="card-body">
                    <form action="" method="post" id="formProduk">
                    <label class="form-label">Nama Produk</label><br>
                    <input type="text" name="nama_produk" required class="input-box"><br><br>
                    <label class="form-label">Artis</label><br>
                    <select name="id_artis" required>
                        <option value="<?= $row['id_artis'] ?>">
                        <?= $row['nama_artis'] ?></option>
                    </select> <br><br>
                    <label class="form-label">Harga</label></label><br>
                    <input type="number" name="harga" required class="input-box"><br><br>

                    <label class="form-label">Stok</label><br>
                    <input type="number"
                    name="stok" required><br><br>

                    <label class="form-label">Detail produk</label></label><br>
                    <textarea name="detail_produk" required class="input-box"></textarea><br><br>

                    <label class="form-label">Gambar Produk:</label><br>
                    <input type="file" name="gambar_produk" class="input-box" required><br><br>

                    <label class="form-label">Tahun Terbit:</label><br>
                    <input type="number" name="thn_terbit" required class="input-box"><br><br>

                    <label class="form-label">Kategori:</label><br>
                    <select name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php while ($row = $kategori->fetch_assoc()) { ?>
                            <option value="<?= $row['id_kategori'] ?>">
                                <?= $row['jenis_kategori'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <br><br>

                    <label class="form-label">Penerbit:</label><br>
                    <select name="id_penerbit" required>
                        <option value="">-- Pilih Penerbit --</option>
                        <?php while ($row = $penerbit->fetch_assoc()) { ?>
                            <option value="<?= $row['id_penerbit'] ?>">
                                <?= $row['nama_penerbit'] ?>
                            </option>
                        <?php } ?>
                    </select>
                    <br><br>

                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </fieldset>
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