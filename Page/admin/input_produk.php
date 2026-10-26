<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../Model/Product.php';
require_once __DIR__ . '/../../Model/artis.php';
require_once __DIR__ . '/../../Model/kategori.php';
require_once __DIR__ . '/../../Model/penerbit.php';

$productModel = new Product();
$artistModel = new Artis();
$kategoriModel = new Kategori();
$penerbitModel = new Penerbit();

$id = $_GET['id'] ?? null;
$row = $id ? $productModel->getById($id) : [];

$artis_list = $artistModel->readAll();
$kategori_list = $kategoriModel->readAll();
$penerbit_list = $penerbitModel->readAll();

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name'          => $_POST['nama_produk'] ?? '',
        'artis_id'      => (int)($_POST['id_artis'] ?? 0),
        'price'         => (int)($_POST['harga'] ?? 0),
        'stock'         => (int)($_POST['stok'] ?? 0),
        'detail'        => $row['detail'] ?? '',
        'gambar_produk' => $row['gambar_produk'] ?? '',
        'thn_terbit'    => (int)($_POST['thn_terbit'] ?? date('Y')),
        'category_id'   => (int)($_POST['id_kategori'] ?? 0),
        'penerbit_id'   => (int)($_POST['id_penerbit'] ?? 0),
        'komentar_id'   => null,
        'jenis_id'      => null,
        'notice'        => $_POST['notice'] ?? '',
        'terms'         => $_POST['terms'] ?? '',
        'size'          => $_POST['size'] ?? '',
        'contents'      => $_POST['contents'] ?? ''
    ];

    $coverDir = __DIR__ . "/../../produk-cover/";
    $detailDir = __DIR__ . "/../../produk-detail/";
    if (!is_dir($coverDir)) {
        mkdir($coverDir, 0777, true);
    }
    if (!is_dir($detailDir)) {
        mkdir($detailDir, 0777, true);
    }

    if (!empty($_FILES['gambar_produk']['name'])) {
        $cover = time() . "_cover_" . preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['gambar_produk']['name']);
        if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $coverDir . $cover)) {
            $data['gambar_produk'] = $cover;
        }
    }

    if (!empty($_FILES['detail_produk']['name'])) {
        $detail = time() . "_detail_" . preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['detail_produk']['name']);
        if (move_uploaded_file($_FILES['detail_produk']['tmp_name'], $detailDir . $detail)) {
            $data['detail'] = $detail;
        }
    }

    try {
        $result = $id ? $productModel->update($id, $data) : $productModel->create($data);
        if ($result) {
            header("Location: read_produk.php?status=success");
            exit;
        } else {
            $error_msg = "Gagal menyimpan produk ke database. Silakan periksa input data.";
        }
    } catch (Exception $e) {
        $error_msg = "Terjadi kesalahan: " . $e->getMessage();
    }
}

$title = $id ? "Edit Produk" : "Form Input Produk";
ob_start();
?>

<div class="d-flex justify-content-end mb-3">
    <a href="read_produk.php" class="btn btn-primary">
        <i class="ti ti-list me-1"></i> Lihat Data Produk
    </a>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <?= $id ? 'Edit Produk' : 'Form Input Produk Baru' ?>
        </h5>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger mb-4">
                <?= htmlspecialchars($error_msg, ENT_QUOTES); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="nama_produk" value="<?= htmlspecialchars($row['nama_produk'] ?? '', ENT_QUOTES) ?>" required class="form-control" placeholder="Cth: MAP OF THE SOUL: 7 Album">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Artis <span class="text-danger">*</span></label>
                    <select name="id_artis" class="form-select" required>
                        <option value="">-- Pilih Artis --</option>
                        <?php if ($artis_list): ?>
                            <?php while ($a = $artis_list->fetch_assoc()): ?>
                                <option value="<?= $a['id_artis'] ?>" <?= (isset($row['id_artis']) && $a['id_artis'] == $row['id_artis']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($a['nama_artis'], ENT_QUOTES) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php if ($kategori_list): ?>
                            <?php while ($k = $kategori_list->fetch_assoc()): ?>
                                <option value="<?= $k['id_kategori'] ?>" <?= (isset($row['id_kategori']) && $k['id_kategori'] == $row['id_kategori']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($k['nama_kategori'], ENT_QUOTES) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga" value="<?= htmlspecialchars($row['harga'] ?? 0, ENT_QUOTES) ?>" required class="form-control" placeholder="350000">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" value="<?= htmlspecialchars($row['stok'] ?? 10, ENT_QUOTES) ?>" required class="form-control" placeholder="10">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Tahun Terbit / Rilis <span class="text-danger">*</span></label>
                    <input type="number" name="thn_terbit" value="<?= htmlspecialchars($row['thn_terbit'] ?? date('Y'), ENT_QUOTES) ?>" required class="form-control" placeholder="<?= date('Y'); ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Penerbit / Label <span class="text-danger">*</span></label>
                <select name="id_penerbit" class="form-select" required>
                    <option value="">-- Pilih Penerbit --</option>
                    <?php if ($penerbit_list): ?>
                        <?php while ($pub = $penerbit_list->fetch_assoc()): ?>
                            <option value="<?= $pub['id_penerbit'] ?>" <?= (isset($row['id_penerbit']) && $pub['id_penerbit'] == $row['id_penerbit']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pub['nama_penerbit'], ENT_QUOTES) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Gambar Cover Produk (Thumbnail) <?= $id ? '<small class="text-muted">(Kosongkan jika tidak diubah)</small>' : '<span class="text-danger">*</span>' ?></label>
                    <input type="file" name="gambar_produk" class="form-control" accept="image/*" <?= $id ? '' : 'required' ?>>
                    <?php if (!empty($row['gambar_produk'])): ?>
                        <div class="mt-2">
                            <img src="/produk-cover/<?= htmlspecialchars($row['gambar_produk'], ENT_QUOTES) ?>" height="60" class="rounded border">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Gambar Detail Produk</label>
                    <input type="file" name="detail_produk" class="form-control" accept="image/*">
                    <?php if (!empty($row['detail'])): ?>
                        <div class="mt-2">
                            <img src="/produk-detail/<?= htmlspecialchars($row['detail'], ENT_QUOTES) ?>" height="60" class="rounded border">
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Notice / Peringatan</label>
                <textarea name="notice" class="form-control" rows="2" placeholder="Catatan pembelian atau spesifikasi khusus"><?= htmlspecialchars($row['notice'] ?? '', ENT_QUOTES) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Terms Recommend</label>
                <textarea name="terms" class="form-control" rows="2" placeholder="Ketentuan atau anjuran produk"><?= htmlspecialchars($row['terms_recomen'] ?? '', ENT_QUOTES) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Ukuran (Size)</label>
                    <input type="text" name="size" value="<?= htmlspecialchars($row['size'] ?? '', ENT_QUOTES) ?>" class="form-control" placeholder="Cth: 150 x 210 x 20 mm">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Isi Paket (Contents)</label>
                    <input type="text" name="contents" value="<?= htmlspecialchars($row['contents'] ?? '', ENT_QUOTES) ?>" class="form-control" placeholder="Cth: CD, Photobook (96p), Photocard (1 of 7)">
                </div>
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                <i class="ti ti-device-floppy me-1"></i> Simpan Produk
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/partials/layout.php';
?>